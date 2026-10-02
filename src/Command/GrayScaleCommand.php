<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Model\Image;

/**
 * Class GrayScaleCommand
 * @package Jackal\ImageMerge\Command
 */
class GrayScaleCommand extends AbstractCommand
{
    public function execute(Image $image): Image
    {
        imagefilter($image->getResource(), IMG_FILTER_GRAYSCALE);

        return $image;
    }
}
