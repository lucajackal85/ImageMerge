<?php

namespace Jackal\ImageMerge\Strategy;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Model\Image;

class ImageBuilderImageStrategy implements ImageBuilderStrategyInterface
{
    /**
     * @param $source
     * @return bool
     */
    public function support($source)
    {
        return is_object($source) and $source instanceof Image;
    }

    /**
     * @param $source
     * @return ImageBuilder
     */
    public function getImageBuilder($source)
    {
        return new ImageBuilder($source);
    }
}
