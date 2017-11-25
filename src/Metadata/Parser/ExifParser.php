<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 19/11/17
 * Time: 15:17
 */

namespace Jackal\ImageMerge\Metadata\Parser;


use Jackal\ImageMerge\Model\File\File;

class ExifParser extends AbstractParser
{

    public function __construct(File $file){

        $this->data = @exif_read_data($file->getPathname());
    }

    public function getMake(){
        return $this->getValue('Make');
    }

    public function getModel(){
        return $this->getValue('Model');
    }

    public function getExposure(){
        return $this->getValue('ExposureTime');
    }

    public function getFlash(){
        return $this->getBooleanValue('Flash');
    }

    public function getISO(){
        return $this->getSingleValue('ISOSpeedRatings');
    }

    public function getResolutionX(){
        return $this->getDivisionValue('XResolution');
    }

    public function getResolutionY(){
        return $this->getDivisionValue('YResolution');
    }

    public function getFocalLength(){
        return $this->getDivisionValue('FocalLength');
    }

    public function getSoftware(){
        return $this->getSingleValue('Software');
    }

    public function getLensModel(){
        return $this->getSingleValue('UndefinedTag:0xA434');
    }

    public function getCameraSerialNumber(){
        return $this->getSingleValue('UndefinedTag:0xA431');
    }

    public function getLensSerialNumber(){
        return $this->getSingleValue('UndefinedTag:0xA435');
    }

    public function getCameraOwnerName(){
        return $this->getSingleValue('UndefinedTag:0xA430');
    }

    public function getLensSpecification(){
        return $this->getValue('UndefinedTag:0xA432');
    }

    public function getExposureCompensation(){
        return $this->getSingleValue('ExposureBiasValue');
    }

    public function getApertureValue(){
        return $this->getDivisionValue('FNumber');
    }

    public function getMeteringMode(){
        return $this->getSingleValue('MeteringMode');
    }

    public function getShutterSpeed(){
        return $this->getSingleValue('ExposureTime');
    }



}