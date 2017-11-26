<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Model\Image;

/**
 * Interface CommandInterface
 * @package Jackal\ImageMerge\Command
 */
interface CommandInterface
{
    /**
     * @return Image
     */
    public function execute();
}
