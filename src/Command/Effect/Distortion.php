<?php

namespace Jackal\ImageMerge\Command\Effect;

use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\Options\MultiCoordinateCommandOption;
use Jackal\ImageMerge\Utils\GeometryUtils;
use Jackal\ImageMerge\ValueObject\Coordinate;
use Jackal\ImageMerge\Model\File\Filename;
use Jackal\ImageMerge\Model\File\FileTempObject;
use Jackal\ImageMerge\Model\Image;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Distortion extends AbstractCommand
{

    /**
     * Distortion constructor.
     * @param Image $image
     * @param MultiCoordinateCommandOption $options
     */
    public function __construct(Image $image, MultiCoordinateCommandOption $options)
    {
        parent::__construct($image, $options);
    }

    /**
     *
     */
    protected function getImageMagickBin()
    {
        $binFolders =[
            '/usr/local/bin',
            '/usr/bin'
        ];

        $finder = new Finder();
        $finder->in($binFolders);

        $finder->files()->name('convert');


        if (!$finder->count()) {
            throw new \RuntimeException(sprintf('Cannot find ImageMagick binaries [Looked into: %s]', implode(',', $binFolders)));
        }

        return $finder->getIterator()->current()->getPathName();
    }


    /**
     * @return Image
     * @throws \Exception
     */
    public function execute()
    {
        $image = $this->image;

        $outputFilepathname = Filename::createTempFilename();

        $inputFile = FileTempObject::fromString($image->toPNG()->getContent());

        /** @var MultiCoordinateCommandOption $options */
        $options = $this->options;

        if (!$options->isQuadrilateral()) {
            throw new \InvalidArgumentException('Coordinates must represent a quadrilateral shape');
        }

        $options = GeometryUtils::getClockwiseOrder($options);

        /** @var Coordinate[] $coordinates */
        $coordinates = $options->getCoordinates();

        $width = $image->getWidth();
        $height = $image->getHeight();

        $cmd = sprintf(
            "%s %s -matte -virtual-pixel black -distort BilinearForward '%s,%s 0,0   %s,%s %s,0   %s,%s %s,%s  %s,%s 0,%s' %s",
            $this->getImageMagickBin(),
            $inputFile->getPathname(),
            $coordinates[0],
            $coordinates[1],
            $coordinates[2],
            $coordinates[3],
            $width,
            $coordinates[4],
            $coordinates[5],
            $width,
            $height,
            $coordinates[6],
            $coordinates[7],
            $height,
            $outputFilepathname
        );

        $process = new Process($cmd);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        //just to delete file after process
        $tempfile = new FileTempObject($outputFilepathname);

        return Image::fromFile($tempfile);
    }
}
