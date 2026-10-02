<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Model\Image;

/**
 * Class FlipHorizontalCommand
 * @package Jackal\ImageMerge\Command
 */
class FlipHorizontalCommand extends AbstractCommand
{
    /**
     * @param Image $image
     * @return Image
     */
    public function execute(Image $image): Image
    {
        imageflip($image->getResource(), IMG_FLIP_HORIZONTAL);

        return $image;
    }
}
