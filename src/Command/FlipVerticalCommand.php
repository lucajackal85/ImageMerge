<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Model\Image;

/**
 * Class FlipVerticalCommand
 * @package Jackal\ImageMerge\Command
 */
class FlipVerticalCommand extends AbstractCommand
{
    const CLASSNAME = __CLASS__;

    /**
     * @return Image
     */
    public function execute()
    {
        imageflip($this->image->getResource(),IMG_FLIP_VERTICAL);

        return $this->image;
    }
}