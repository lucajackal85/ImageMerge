<?php

namespace Jackal\ImageMerge\Command;

use InvalidArgumentException;
use Jackal\ImageMerge\Command\Options\CropCommandOption;
use Jackal\ImageMerge\Model\Image;
use RuntimeException;

/**
 * Class CropCommand
 * @package Jackal\ImageMerge\Command
 */
class CropCommand extends AbstractCommand
{
    /**
     * CropCommand constructor.
     */
    public function __construct(CropCommandOption $options)
    {
        parent::__construct($options);
    }

    public function execute(Image $image): Image
    {
        /** @var CropCommandOption $options */
        $options = $this->options;
        $x = (int) $options->getCoordinate1()->getX();
        $y = (int) $options->getCoordinate1()->getY();
        $width = (int) $options->getDimension()->getWidth();
        $height = (int) $options->getDimension()->getHeight();

        if ($x < 0 || $y < 0 || $width < 1 || $height < 1 || $x + $width > $image->getWidth() || $y + $height > $image->getHeight()) {
            throw new InvalidArgumentException(sprintf(
                'Crop area %dx%d at %d,%d exceeds the image dimensions %dx%d',
                $width,
                $height,
                $x,
                $y,
                $image->getWidth(),
                $image->getHeight()
            ));
        }

        if ($x === 0 && $y === 0 && $width === $image->getWidth() && $height === $image->getHeight()) {
            return $image;
        }

        $newImage = imagecrop($image->getResource(), ['x' => $x, 'y' => $y, 'width' => $width, 'height' => $height]);
        if ($newImage === false) {
            throw new RuntimeException('Unable to crop image');
        }

        return $image->assignResource($newImage);
    }
}
