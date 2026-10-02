<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Model\Image;

/**
 * Class FlipVerticalCommand
 * @package Jackal\ImageMerge\Command
 */
class FlipVerticalCommand extends AbstractCommand
{
    public function execute(Image $image): Image
    {
        imageflip($image->getResource(), IMG_FLIP_VERTICAL);

        return $image;
    }
}
