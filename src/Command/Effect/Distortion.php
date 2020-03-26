<?php

namespace Jackal\ImageMerge\Command\Effect;

use Exception;
use InvalidArgumentException;
use Jackal\BinLocator\BinLocator;
use Jackal\ImageMerge\Command\Options\MultiCoordinateCommandOption;
use Jackal\ImageMerge\Utils\GeometryUtils;
use Jackal\ImageMerge\ValueObject\Coordinate;
use Jackal\ImageMerge\Model\File\Filename;
use Jackal\ImageMerge\Model\File\FileTempObject;
use Jackal\ImageMerge\Model\Image;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Distortion extends AbstractImageMagickCommand
{
    /**
     * Distortion constructor.
     * @param MultiCoordinateCommandOption $options
     */
    public function __construct(MultiCoordinateCommandOption $options)
    {
        parent::__construct($options);
    }

    /**
     * @param Image $image
     * @return Image
     * @throws Exception
     */
    public function execute(Image $image)
    {
        $originImage = $image;

        $outputFilepathname = Filename::createTempFilename();

        $inputFile = FileTempObject::fromString($originImage->toPNG()->getContent());

        /** @var MultiCoordinateCommandOption $options */
        $options = $this->options;

        if (!$options->isQuadrilateral()) {
            throw new InvalidArgumentException('Coordinates must represent a quadrilateral shape');
        }

        $options = GeometryUtils::getClockwiseOrder($options);

        /** @var Coordinate[] $coordinates */
        $coordinates = $options->toArray();

        $width = $originImage->getWidth();
        $height = $originImage->getHeight();

        $locator = new BinLocator('convert');

        $process = $locator->getProcess([
            $inputFile->getPathname(),
            '-matte -virtual-pixel black -distort Perspective',
            sprintf(
                "'%s,%s 0,0   %s,%s %s,0   %s,%s %s,%s  %s,%s 0,%s' %s",
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
            ),
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        //just to delete file after process
        $tempfile = new FileTempObject($outputFilepathname);

        return Image::fromFile($tempfile);
    }
}
