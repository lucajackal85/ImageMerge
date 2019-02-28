<?php


namespace Jackal\ImageMerge\Command\Effect;


use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Utils\ImageMagickUtils;
use Symfony\Component\Finder\Finder;

abstract class AbstractImageMagickCommand extends AbstractCommand
{
    /**
     *
     */
    protected function getImageMagickBin()
    {
        return ImageMagickUtils::getImageMagickBin();
    }
}