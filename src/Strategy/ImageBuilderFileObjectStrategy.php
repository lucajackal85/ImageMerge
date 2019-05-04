<?php


namespace Jackal\ImageMerge\Strategy;

use Exception;
use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Metadata\Metadata;
use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Model\Image;

class ImageBuilderFileObjectStrategy implements ImageBuilderStrategyInterface
{

    /**
     * @param $source
     * @return bool
     */
    public function support($source)
    {
        return is_object($source) and $source instanceof FileObject;
    }

    /**
     * @param $source
     * @return ImageBuilder
     * @throws Exception
     */
    public function getImageBuilder($source)
    {
        $image = Image::fromFile($source);
        $image->addMetadata(new Metadata($source));

        return new ImageBuilder($image);
    }
}
