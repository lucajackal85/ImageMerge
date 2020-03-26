<?php

namespace Jackal\ImageMerge\Strategy;

use Exception;
use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Metadata\Metadata;
use Jackal\ImageMerge\Model\File\FileTempObject;
use Jackal\ImageMerge\Model\Image;

class ImageBuilderURLStrategy implements ImageBuilderStrategyInterface
{
    /**
     * @param $source
     * @return bool
     */
    public function support($source)
    {
        return is_string($source) and filter_var($source, FILTER_VALIDATE_URL);
    }

    /**
     * @param $source
     * @return ImageBuilder
     * @throws Exception
     */
    public function getImageBuilder($source)
    {
        $image = Image::fromString(file_get_contents($source));
        $image->addMetadata(new Metadata(FileTempObject::fromString($source)));

        return new ImageBuilder($image);
    }
}
