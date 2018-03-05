<?php


namespace Jackal\ImageMerge;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Metadata\Metadata;
use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Model\File\FileTempObject;
use Jackal\ImageMerge\Model\Image;

class ImageMerge
{
    /**
     * @param Image|FileObject|string $source
     * @return ImageBuilder
     * @throws \Exception
     */
    public function getImageBuilder($source)
    {
        switch (true) {
            case is_object($source) and $source instanceof Image:{
                $image = $source;
                break;
            }
            case is_object($source) and $source instanceof FileObject:{
                $image = Image::fromFile($source);
                $image->addMetadata(new Metadata($source));
                break;
            }
            case is_string($source):{
                $image = Image::fromString($source);
                $image->addMetadata(new Metadata(FileTempObject::fromString($source)));
                break;
            }
            default:
                throw new \InvalidArgumentException('Cannot instantiate ImageBuilder');
        }

        return new ImageBuilder($image);
    }
}
