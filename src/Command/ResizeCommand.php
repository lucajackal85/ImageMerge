<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Model\Image;

class ResizeCommand extends AbstractCommand
{

    /**
     * ResizeCommand constructor.
     * @param Image $image
     * @param DimensionCommandOption $options
     */
    public function __construct(Image $image, DimensionCommandOption $options)
    {
        parent::__construct($image, $options);
    }

    /**
     * @return Image
     */
    public function execute()
    {
        $width = $this->options->getWidth();
        $height = $this->options->getHeight();

        if ($this->image->getWidth() != $width or $this->image->getHeight() != $height) {
            $resourceResized = imagecreatetruecolor($width, $height);
            imagecolortransparent($resourceResized);
            imagecopyresampled($resourceResized, $this->image->getResource(), 0, 0, 0, 0, $width, $height, $this->image->getWidth(), $this->image->getHeight());

            return $this->image->assignResource($resourceResized);
        }
        return $this->image;
    }
}
