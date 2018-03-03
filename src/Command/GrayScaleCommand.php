<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Model\Image;

/**
 * Class GrayScaleCommand
 * @package Jackal\ImageMerge\Command
 */
class GrayScaleCommand extends AbstractCommand
{

    const CLASSNAME = __CLASS__;

    /**
     * GrayScaleCommand constructor.
     * @param Image $image
     */
    public function __construct(Image $image)
    {
        parent::__construct($image, null);
    }

    /**
     * @return Image
     */
    public function execute()
    {
        imagefilter($this->image->getResource(), IMG_FILTER_GRAYSCALE);
        return $this->image;
    }
}
