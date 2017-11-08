<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 30/08/17
 * Time: 15.47
 */

namespace Jackal\ImageMerge\Model\Format;

use Jackal\ImageMerge\Model\File\File;
use Jackal\ImageMerge\Model\File\FileInterface;

class ImageReader
{
    private $resource;

    private $format;

    /**
     * @param FileInterface $filename
     * @return ImageReader
     * @throws \Exception
     */
    public static function fromPathname(FileInterface $filename)
    {
        $ir = new self();
        $ir->resource = imagecreatefromstring($filename->getContents());

        switch (exif_imagetype($filename->getPathname())) {
            case IMAGETYPE_PNG:{
                $ir->format =  ImageFormat::PNG;
                break;
            }
            case IMAGETYPE_JPEG:{
                $ir->format = ImageFormat::JPG;
                break;
            }
            case IMAGETYPE_GIF:{
                $ir->format = ImageFormat::GIF;
                break;
            }
            default: {
                throw new \Exception(sprintf('File is not a valid image type [%s]',exif_imagetype($filename->getPathname())));
            }
        }

        if (function_exists('imageantialias')) {
            imageantialias($ir->resource, true);
        }

        return $ir;
    }

    public static function fromString($string)
    {
        return self::fromPathname(File::fromString($string));
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
