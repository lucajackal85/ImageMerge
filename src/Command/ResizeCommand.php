<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Limits;
use Jackal\ImageMerge\Model\Image;

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
    public function execute(Image $image): Image
    {
        $width = $this->options->getDimension()->getWidth();
        $height = $this->options->getDimension()->getHeight();

        if (!$width) {
            $width = (int) round($image->getAspectRatio() * $height);
        }

        if (!$height) {
            $height = (int) round($width / $image->getAspectRatio());
        }

        Limits::default()->assertDimensions((int) $width, (int) $height);

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
