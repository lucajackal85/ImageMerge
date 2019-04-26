<?php

namespace Jackal\ImageMerge\Model\Format;

use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Model\File\FileObjectInterface;

/**
 * Class ImageReader
 * @package Jackal\ImageMerge\Model\Format
 */
final class ImageReader
{
    const FORMAT_JPG = 'jpg';
    const FORMAT_PNG = 'png';
    const FORMAT_GIF = 'gif';
    const FORMAT_WEBP = 'webp';

    private $resource;

    private $format;

    private function __construct()
    {
        //IMAGETYPE_WEBP is available only from php 7.1
        if(!defined('IMAGETYPE_WEBP')){
            define('IMAGETYPE_WEBP',18);
        }
    }

    /**
     * @param FileObjectInterface $filename
     * @return ImageReader
     * @throws \Exception
     */
    public static function fromPathname(FileObjectInterface $filename)
    {
        $ir = new self();
        $ir->resource = @imagecreatefromstring($filename->getContents());

        switch ($ir->getExifType($filename)) {
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
            case IMAGETYPE_WEBP:{
                $ir->format = self::FORMAT_WEBP;
                break;
            }
            default: {
                throw new \Exception(sprintf('File is not a valid image type [extension: "%s"]',
                    $ir->getExtension($filename))
                );

            }
        }

        return $ir;
    }

    private function getExtension(FileObjectInterface $filename){
        return strtolower(pathinfo($filename->getPathname(), PATHINFO_EXTENSION));
    }

    private function getExifType(FileObjectInterface $filename){
        $imageType = exif_imagetype($filename->getPathname());

        if(!$imageType){
            //since IMAGETYPE_WEBP is available only from php 7.1, we guess the type base from the extension
            if(version_compare(PHP_VERSION, '7.1.0', '<') and $this->getExtension($filename) == 'webp'){
                return IMAGETYPE_WEBP;
            }
        }

        return $imageType;

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
