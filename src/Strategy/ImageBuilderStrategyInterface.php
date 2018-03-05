<?php


namespace Jackal\ImageMerge\Strategy;

use Jackal\ImageMerge\Builder\ImageBuilder;

/**
 * Interface ImageBuilderStrategyInterface
 * @package Jackal\ImageMerge\Strategy
 */
interface ImageBuilderStrategyInterface
{
    /**
     * @param $source
     * @return bool
     */
    public function support($source);

    /**
     * @param $source
     * @return ImageBuilder
     */
    public function getImageBuilder($source);
}
