<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Model\Image;

/**
 * Class FlipHorizontalCommand
 * @package Jackal\ImageMerge\Command
 */
class FlipHorizontalCommand extends AbstractCommand
{
    const CLASSNAME = __CLASS__;

    /**
     * @return Image
     */
    public function execute()
    {
        imageflip($this->image->getResource(),IMG_FLIP_HORIZONTAL);

        return $this->image;
    }
}