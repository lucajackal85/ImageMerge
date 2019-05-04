<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Model\Image;

/**
 * Class GrayScaleCommand
 * @package Jackal\ImageMerge\Command
 */
class GrayScaleCommand extends AbstractCommand
{

    /**
     * GrayScaleCommand constructor.
     */
    public function __construct()
    {
        parent::__construct(null);
    }

    /**
     * @param Image $image
     * @return Image
     */
    public function execute(Image $image)
    {
        imagefilter($image->getResource(), IMG_FILTER_GRAYSCALE);
        return $image;
    }
}
