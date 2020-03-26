<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\ValueObject\Dimention;

class ResizeCommand extends AbstractCommand
{
    /**
     * ResizeCommand constructor.
     * @param DimensionCommandOption $options
     */
    public function __construct(DimensionCommandOption $options)
    {
        parent::__construct($options);
    }

    /**
     * @param Image $image
     * @return Image
     */
    public function execute(Image $image)
    {
        if (!$this->options->getDimention()->getWidth()) {
            $this->options->add('dimention', new Dimention(round($image->getAspectRatio() * $this->options->getDimention()->getHeight()), $this->options->getDimention()->getHeight()));
        }

        if (!$this->options->getDimention()->getHeight()) {
            $this->options->add('dimention', new Dimention($this->options->getDimention()->getWidth(), round($this->options->getDimention()->getWidth() / $image->getAspectRatio())));
        }

        $width = $this->options->getDimention()->getWidth();
        $height = $this->options->getDimention()->getHeight();

        if ($image->getWidth() != $width or $image->getHeight() != $height) {
            $resourceResized = imagecreatetruecolor($width, $height);
            imagealphablending($resourceResized, false);
            imagesavealpha($resourceResized, true);
            $transparent = imagecolorallocatealpha($resourceResized, 255, 255, 255, 127);
            imagecolortransparent($resourceResized, $transparent);
            imagecopyresampled($resourceResized, $image->getResource(), 0, 0, 0, 0, $width, $height, $image->getWidth(), $image->getHeight());

            return $image->assignResource($resourceResized);
        }

        return $image;
    }
}
