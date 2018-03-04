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
        /** @var CropCommandOption $options */
        $options = $this->options;
        $newImage = imagecrop($this->image->getResource(), [
            'x' => $options->getCoordinate1()->getX(),
            'y' => $options->getCoordinate1()->getY(),
            'width' => $options->getWidth(),
            'height' => $options->getHeight()
        ]);

        return $this->image->assignResource($newImage);
    }
}
