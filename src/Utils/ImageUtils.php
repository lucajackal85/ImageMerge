<?php

namespace Jackal\ImageMerge\Utils;

/**
 * Class ImageUtils
 * @package Jackal\ImageMerge\Utils
 */
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
