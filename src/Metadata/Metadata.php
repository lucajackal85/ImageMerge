<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 10/11/17
 * Time: 9.15
 */

namespace Jackal\ImageMerge\Metadata;

use Jackal\ImageMerge\Model\File\File;

class Metadata
{
    private $metadata;

    public function __construct(File $file)
    {
        $this->metadata = exif_read_data($file->getPathname());
    }

    public function all(){
        return $this->metadata;
    }

    public function getCameraMake()
    {
        return $this->metadata['Make'];
    }

    public function getCameraModel()
    {
        return $this->metadata['Model'];
    }

    public function getCameraExposure()
    {
        return $this->metadata['ExposureTime'];
    }

    public function getCameraAperture(){


    }

    public function getCameraFocalLength(){
        $length = $this->metadata['FocalLength'];
        if(strpos($length,'/1') !== false) {
            return (int)str_replace('/1', '', $length);
        }

        return $length;
    }

    public function getCameraISO(){
        return $this->metadata['ISOSpeedRatings'];
    }

    public function getCameraFlash(){

        return $this->metadata['Flash'] == true;
    }
}
