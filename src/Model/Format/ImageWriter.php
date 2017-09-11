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
    
    public static function toPNG($resource, $filePathName = null)
    {
        ob_start();
        imagepng($resource, null, 9);
        $content = ob_get_clean();

        if ($filePathName) {
            ImageWriter::checkPermissions($filePathName);
            return file_put_contents($filePathName, $content)== true;
        }
        return $content;
    }

    public static function toJPG($resource, $filePathName=null)
    {
        ob_start();

        imagejpeg($resource, null, 100);
        $content = ob_get_clean();

        if ($filePathName) {
            ImageWriter::checkPermissions($filePathName);
            return file_put_contents($filePathName, $content) == true;
        }
        return $content;
    }

    public static function toGIF($resource, $filePathName=null)
    {
        ob_start();
        imagegif($resource);
        $content = ob_get_clean();

        if ($filePathName) {
            ImageWriter::checkPermissions($filePathName);
            return file_put_contents($filePathName, $content) == true;
        }
        return $content;
    }
}
