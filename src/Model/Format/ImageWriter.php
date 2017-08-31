<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 30/08/17
 * Time: 17.56
 */

namespace Jackal\ImageMerge\Model\Format;

class ImageWriter
{
    public static function toPNG($resource)
    {
        ob_start();
        imagepng($resource);
        return ob_get_clean();
    }

    public static function toJPG($resource)
    {
        ob_start();

        imagejpeg($resource);
        return ob_get_clean();
    }

    public static function toGIF($resource)
    {
        ob_start();
        imagegif($resource);
        return ob_get_clean();
    }
}
