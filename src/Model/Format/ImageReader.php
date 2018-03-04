<?php

namespace Jackal\ImageMerge\Model\Format;

use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Model\File\FileObjectInterface;

/**
 * Class ImageReader
 * @package Jackal\ImageMerge\Model\Format
 */
class ImageReader
{
    const FORMAT_JPG = 'jpg';
    const FORMAT_PNG = 'png';
    const FORMAT_GIF = 'gif';

    private $resource;

    private $format;

    /**
     * @param FileObjectInterface $filename
     * @return ImageReader
     * @throws \Exception
     */
    public static function fromPathname(FileObjectInterface $filename)
    {
        $ir = new self();
        $ir->resource = imagecreatefromstring($filename->getContents());

        switch (exif_imagetype($filename->getPathname())) {
            case IMAGETYPE_PNG:{
                $ir->format =  self::FORMAT_PNG;
                break;
            }
            case IMAGETYPE_JPEG:{
                $ir->format = self::FORMAT_JPG;
                break;
            }
            case IMAGETYPE_GIF:{
                $ir->format = self::FORMAT_GIF;
                break;
            }
            default: {
                throw new \Exception(sprintf('File is not a valid image type [%s]', exif_imagetype($filename->getPathname())));
            }
        }

        if (function_exists('imageantialias')) {
            imageantialias($ir->resource, true);
        }

        return $ir;
    }

    /**
     * @param $string
     * @return ImageReader
     * @throws \Exception
     */
    public static function fromString($string)
    {
        return self::fromPathname(FileObject::fromString($string));
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return resource
     */
    public function getResource()
    {
        return $this->resource;
    }
}
