<?php

namespace Jackal\ImageMerge\Model\Format;
use Jackal\ImageMerge\Model\ImageContent\ImageGIFContent;
use Jackal\ImageMerge\Model\ImageContent\ImageJPGContent;
use Jackal\ImageMerge\Model\ImageContent\ImagePNGContent;

/**
 * Class ImageWriter
 * @package Jackal\ImageMerge\Model\Format
 */
class ImageWriter
{
    /**
     * @param $filePathName
     * @throws \Exception
     */
    private static function checkPermissions($filePathName)
    {
        $directory = dirname($filePathName);
        if (!is_dir($directory)) {
            if (!mkdir(dirname($filePathName), 0777, true)) {
                throw new \Exception(sprintf('Cannot create folder %s', $directory));
            }
        }
        if (!is_writable($directory)) {
            throw new \Exception(sprintf('Cannot write into directory: %s', $directory));
        }
    }

    /**
     * @param $resource
     * @param null $filePathName
     * @return bool|ImagePNGContent
     */
    public static function toPNG($resource, $filePathName = null)
    {
        ob_start();
        imagepng($resource, null, 9);
        $content = ob_get_clean();

        if ($filePathName) {
            ImageWriter::checkPermissions($filePathName);
            return file_put_contents($filePathName, $content)== true;
        }
        return new ImagePNGContent($content);
    }

    /**
     * @param $resource
     * @param null $filePathName
     * @return bool|ImageJPGContent
     */
    public static function toJPG($resource, $filePathName=null)
    {
        ob_start();

        imagejpeg($resource, null, 100);
        $content = ob_get_clean();

        if ($filePathName) {
            ImageWriter::checkPermissions($filePathName);
            return file_put_contents($filePathName, $content) == true;
        }
        return new ImageJPGContent($content);
    }

    /**
     * @param $resource
     * @param null $filePathName
     * @return bool|ImageGIFContent
     */
    public static function toGIF($resource, $filePathName=null)
    {
        ob_start();
        imagegif($resource);
        $content = ob_get_clean();

        if ($filePathName) {
            ImageWriter::checkPermissions($filePathName);
            return file_put_contents($filePathName, $content) == true;
        }
        return new ImageGIFContent($content);
    }
}
