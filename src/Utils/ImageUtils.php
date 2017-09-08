<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 08/09/17
 * Time: 17.47
 */

namespace Jackal\ImageMerge\Utils;

class ImageUtils
{
    /**
     * @param $filePathName
     * @return int
     */
    public static function getImageWidth($filePathName)
    {
        return self::getImageDimensions($filePathName)[0];
    }

    /**
     * @param $filePathName
     * @return int
     */
    public static function getImageHeight($filePathName)
    {
        return self::getImageDimensions($filePathName)[1];
    }

    /**
     * @param $filePathName
     * @return array
     */
    private static function getImageDimensions($filePathName)
    {
        return getimagesize($filePathName);
    }
}
