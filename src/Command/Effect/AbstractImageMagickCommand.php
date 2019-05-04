<?php


namespace Jackal\ImageMerge\Command\Effect;

use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Utils\ImageMagickUtils;

abstract class AbstractImageMagickCommand extends AbstractCommand
{
    /**
     * @return string
     */
    protected function getImageMagickBin()
    {
        return ImageMagickUtils::getImageMagickBin();
    }
}
