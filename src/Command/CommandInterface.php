<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Model\Image;

/**
 * Interface CommandInterface
 * @package Jackal\ImageMerge\Command
 */
interface CommandInterface
{
    public function execute(Image $image): Image;
}
