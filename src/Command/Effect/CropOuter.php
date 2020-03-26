<?php

namespace Jackal\ImageMerge\Command\Effect;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Model\Image;

class CropOuter extends AbstractCommand
{
    /**
     * CropOuter constructor.
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
        $newWidth = $this->options->getDimention()->getWidth();
        $newHeight = $this->options->getDimention()->getHeight();

        $thumbAspect = $newWidth / $newHeight;
        $builder = new ImageBuilder($image);
        if ($image->getAspectRatio() >= $thumbAspect) {
            $builder->resize($newWidth, null);
        } else {
            $builder->resize(null, $newHeight);
        }

        $posX = ($newWidth - $image->getWidth()) / 2;
        $posY = ($newHeight - $image->getHeight()) / 2;

        $image_p = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($image_p, $image->getResource(), $posX, $posY, 0, 0, $image->getWidth(), $image->getHeight(), $image->getWidth(), $image->getHeight());

        $image->assignResource($image_p);

        return $image;
    }
}
