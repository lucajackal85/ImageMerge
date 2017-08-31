<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 30/08/17
 * Time: 15.47
 */

namespace Jackal\ImageMerge\Model\Format;

class ImageReader
{
    private $resource;

    private $format;

    public static function fromPathname($filename)
    {
        $ir = new self();
        switch (exif_imagetype($filename)) {
            case IMAGETYPE_PNG:{
                $ir->resource = imagecreatefrompng($filename);
                $ir->format =  ImageFormat::PNG;
                break;
            }
            case IMAGETYPE_JPEG:{
                $ir->resource = imagecreatefromjpeg($filename);
                $ir->format = ImageFormat::JPG;
                break;
            }
            case IMAGETYPE_GIF:{
                $ir->resource = imagecreatefromgif($filename);
                $ir->format = ImageFormat::GIF;
                break;
            }
            default: {
                throw new \Exception(exif_imagetype($filename));
            }
        }
        return $ir;
    }

    public static function fromString($string)
    {
        $path = sys_get_temp_dir().'/'.microtime();
        $h = fopen($path,'w');
        fputs($h,$string);
        return self::fromPathname($path);
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
