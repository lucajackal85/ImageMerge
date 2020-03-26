<?php

namespace Jackal\ImageMerge\Strategy;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Metadata\Metadata;
use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Model\Image;

class ImageBuilderSplFileObjectStrategy implements ImageBuilderStrategyInterface
{
    /**
     * @param $source
     * @return bool
     */
    public function support($source)
    {
        return is_object($source) and $source instanceof \SplFileObject;
    }

    /**
     * @param \SplFileObject $source
     * @return ImageBuilder
     * @throws \Exception
     */
    public function getImageBuilder($source)
    {
        $fileObject = new FileObject($source->getPathname());

        $image = Image::fromFile($fileObject);
        $image->addMetadata(new Metadata($fileObject));

        return new ImageBuilder($image);
    }
}
