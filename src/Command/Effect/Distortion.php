<?php

namespace Jackal\ImageMerge\Command\Effect;

use Exception;
use InvalidArgumentException;
use Jackal\ImageMerge\Command\Options\MultiCoordinateCommandOption;
use Jackal\ImageMerge\Model\File\Filename;
use Jackal\ImageMerge\Model\File\FileTempObject;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\Utils\GeometryUtils;
use Jackal\ImageMerge\ValueObject\Coordinate;
use RuntimeException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ExecutableFinder;
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
    public function execute(Image $image): Image
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

        $process = new Process(array_merge(self::getImageMagickCommand(), [
            $inputFile->getPathname(),
            '-alpha', 'set',
            '-virtual-pixel', 'black',
            '-distort', 'Perspective',
            sprintf(
                '%s,%s 0,0 %s,%s %s,0 %s,%s %s,%s %s,%s 0,%s',
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
                $height
            ),
            'png:' . $outputFilepathname,
        ]));

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        //just to delete file after process
        $tempfile = new FileTempObject($outputFilepathname);

        return Image::fromFile($tempfile);
    }

    /**
     * ImageMagick 7 ships "magick", ImageMagick 6 only "convert".
     *
     * @return string[]
     */
    private static function getImageMagickCommand(): array
    {
        $finder = new ExecutableFinder();

        if ($magick = $finder->find('magick')) {
            return [$magick];
        }

        if ($convert = $finder->find('convert')) {
            return [$convert];
        }

        throw new RuntimeException('ImageMagick not found: install it to use the Distortion effect');
    }
}
