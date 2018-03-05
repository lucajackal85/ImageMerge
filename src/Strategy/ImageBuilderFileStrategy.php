<?php


namespace Jackal\ImageMerge\Strategy;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Metadata\Metadata;
use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Model\File\FileTempObject;
use Jackal\ImageMerge\Model\Image;

/**
 * Class ImageBuilderFileStrategy
 * @package Jackal\ImageMerge\Strategy
 */
class ImageBuilderFileStrategy implements ImageBuilderStrategyInterface
{

    /**
     * @param $source
     * @return bool
     */
    public function support($source)
    {
        return is_string($source) and @is_file($source);
    }

    /**
     * @param $source
     * @return ImageBuilder
     * @throws \Exception
     */
    public function getImageBuilder($source)
    {
        $image = Image::fromFile(new FileObject($source));
        $image->addMetadata(new Metadata(FileTempObject::fromString($source)));

        return new ImageBuilder($image);
    }
}
