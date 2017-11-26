<?php

namespace Jackal\ImageMerge\Metadata\Parser;

use Jackal\ImageMerge\Model\File\FileInterface;

/**
 * Class ExifParser
 * @package Jackal\ImageMerge\Metadata\Parser
 */
class ExifParser extends AbstractParser
{
    /**
     * ExifParser constructor.
     * @param FileInterface $file
     */
    public function __construct(FileInterface $file){

        $this->data = @exif_read_data($file->getPathname());
    }

    /**
     * @return null|string
     */
    public function getMake(){
        return $this->getSingleValue('Make');
    }

    /**
     * @return null|string
     */
    public function getModel(){
        return $this->getSingleValue('Model');
    }

    /**
     * @return null|string
     */
    public function getExposure(){
        return $this->getSingleValue('ExposureTime');
    }

    /**
     * @return bool|null
     */
    public function getFlash(){
        return $this->getBooleanValue('Flash');
    }

    /**
     * @return null|string
     */
    public function getISO(){
        return $this->getSingleValue('ISOSpeedRatings');
    }

    /**
     * @return int|string
     */
    public function getResolutionX(){
        return $this->getDivisionValue('XResolution');
    }

    /**
     * @return int|string
     */
    public function getResolutionY(){
        return $this->getDivisionValue('YResolution');
    }

    /**
     * @return int|string
     */
    public function getFocalLength(){
        return $this->getDivisionValue('FocalLength');
    }

    /**
     * @return null|string
     */
    public function getSoftware(){
        return $this->getSingleValue('Software');
    }

    /**
     * @return null|string
     */
    public function getLensModel(){
        return $this->getSingleValue('UndefinedTag:0xA434');
    }

    /**
     * @return null|string
     */
    public function getCameraSerialNumber(){
        return $this->getSingleValue('UndefinedTag:0xA431');
    }

    /**
     * @return null|string
     */
    public function getLensSerialNumber(){
        return $this->getSingleValue('UndefinedTag:0xA435');
    }

    /**
     * @return null|string
     */
    public function getCameraOwnerName(){
        return $this->getSingleValue('UndefinedTag:0xA430');
    }

    /**
     * @return null|string
     */
    public function getLensSpecification(){
        return $this->getSingleValue('UndefinedTag:0xA432');
    }

    /**
     * @return null|string
     */
    public function getExposureCompensation(){
        return $this->getSingleValue('ExposureBiasValue');
    }

    /**
     * @return int|string
     */
    public function getApertureValue(){
        return $this->getDivisionValue('FNumber');
    }

    /**
     * @return null|string
     */
    public function getMeteringMode(){
        return $this->getSingleValue('MeteringMode');
    }

    /**
     * @return null|string
     */
    public function getShutterSpeed(){
        return $this->getSingleValue('ExposureTime');
    }



}