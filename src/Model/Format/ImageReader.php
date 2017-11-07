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
        switch (exif_imagetype($filename->getPathname())) {
            case IMAGETYPE_PNG:{
                $ir->resource = imagecreatefrompng($filename->getPathname());
                $ir->format =  ImageFormat::PNG;
                break;
            }
            case IMAGETYPE_JPEG:{
                $ir->resource = imagecreatefromjpeg($filename->getPathname());
                $ir->format = ImageFormat::JPG;
                break;
            }
            case IMAGETYPE_GIF:{
                $ir->resource = imagecreatefromgif($filename->getPathname());
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
        $path = sys_get_temp_dir().'/'.microtime();
        $h = fopen($path, 'w');
        fputs($h, $string);
        return self::fromPathname(new File($path));
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
