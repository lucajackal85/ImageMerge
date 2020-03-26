<?php

namespace Jackal\ImageMerge\Strategy;

use Exception;
use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Metadata\Metadata;
use Jackal\ImageMerge\Model\File\FileTempObject;
use Jackal\ImageMerge\Model\Image;

class ImageBuilderResourceStrategy implements ImageBuilderStrategyInterface
{
    /**
     * @param $source
     * @return bool
     */
    public function support($source)
    {
        return is_resource($source);
    }

    /**
     * @param $source
     * @return ImageBuilder
     * @throws Exception
     */
    public function getImageBuilder($source)
    {
        $source = stream_get_contents($source);

        $image = Image::fromString($source);
        $image->addMetadata(new Metadata(FileTempObject::fromString($source)));

        return new ImageBuilder($image);
    }
}
