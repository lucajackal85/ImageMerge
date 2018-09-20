<?php

namespace Jackal\ImageMerge\Command;

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
     * @param Image $image
     * @param CropCommandOption $options
     */
    public function __construct(Image $image, CropCommandOption $options)
    {
        parent::__construct($image, $options);
    }

    /**
     * @return Image
     */
    public function execute()
    {
        if ($this->image->getWidth() == $this->options->getDimention()->getWidth() and $this->image->getHeight() == $this->options->getDimention()->getHeight()) {
            return $this->image;
        }

        if ($this->options->getDimention()->getWidth() > $this->image->getWidth() || $this->options->getDimention()->getHeight() > $this->image->getHeight()) {
            throw new \InvalidArgumentException(sprintf('Crop area exceed, max dimensions are: %s X %s', $this->image->getWidth(), $this->image->getHeight()));
        }

        /** @var CropCommandOption $options */
        $options = $this->options;
        $newImage = imagecrop($this->image->getResource(), [
            'x' => $options->getCoordinate1()->getX(),
            'y' => $options->getCoordinate1()->getY(),
            'width' => $options->getDimention()->getWidth(),
            'height' => $options->getDimention()->getHeight()
        ]);

        return $this->image->assignResource($newImage);
    }
}
