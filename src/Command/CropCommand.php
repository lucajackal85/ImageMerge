<?php

namespace Jackal\ImageMerge\Command;

use InvalidArgumentException;
use Jackal\ImageMerge\Command\Options\CropCommandOption;
use Jackal\ImageMerge\Model\Image;

/**
 * Class CropCommand
 * @package Jackal\ImageMerge\Command
 */
class CropCommand extends AbstractCommand
{
    /**
     * CropCommand constructor.
     * @param CropCommandOption $options
     */
    public function __construct(CropCommandOption $options)
    {
        parent::__construct($options);
    }

    /**
     * @param Image $image
     * @return Image
     */
    public function execute(Image $image)
    {
        if ($image->getWidth() == $this->options->getDimention()->getWidth() and $image->getHeight() == $this->options->getDimention()->getHeight()) {
            return $image;
        }

        if ($this->options->getDimention()->getWidth() > $image->getWidth() || $this->options->getDimention()->getHeight() > $image->getHeight()) {
            throw new InvalidArgumentException(sprintf('Crop area exceed, max dimensions are: %s X %s', $image->getWidth(), $image->getHeight()));
        }

        /** @var CropCommandOption $options */
        $options = $this->options;
        $newImage = imagecrop($image->getResource(), [
            'x' => $options->getCoordinate1()->getX(),
            'y' => $options->getCoordinate1()->getY(),
            'width' => $options->getDimention()->getWidth(),
            'height' => $options->getDimention()->getHeight(),
        ]);

        return $image->assignResource($newImage);
    }
}
