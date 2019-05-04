<?php

namespace Jackal\ImageMerge\Metadata\Parser;

use Jackal\ImageMerge\Exception\ModuleNotFoundException;
use Jackal\ImageMerge\Model\File\FileObjectInterface;

/**
 * Class ExifParser
 * @package Jackal\ImageMerge\Metadata\Parser
 */
class ExifParser extends AbstractParser
{
    /**
     * ExifParser constructor.
     * @param FileObjectInterface $file
     * @throws ModuleNotFoundException
     */
    public function __construct(FileObjectInterface $file)
    {
        if (!function_exists('exif_read_data')) {
            throw new ModuleNotFoundException('function exif_read_data not installed');
        }
        $this->data = @exif_read_data($file->getPathname());
    }

    /**
     * @return null|string
     */
    public function getMake()
    {
        return $this->getSingleValue('Make');
    }

    /**
     * @return null|string
     */
    public function getModel()
    {
        return $this->getSingleValue('Model');
    }

    /**
     * @return null|string
     */
    public function getExposure()
    {
        return $this->getSingleValue('ExposureTime');
    }

    /**
     * @return bool|null
     */
    public function getFlash()
    {
        return $this->getBooleanValue('Flash');
    }

    /**
     * @return null|string
     */
    public function getISO()
    {
        return $this->getSingleValue('ISOSpeedRatings');
    }

    /**
     * @return int|string
     */
    public function getResolutionX()
    {
        return $this->getDivisionValue('XResolution');
    }

    /**
     * @return int|string
     */
    public function getResolutionY()
    {
        return $this->getDivisionValue('YResolution');
    }

    /**
     * @return int|string
     */
    public function getFocalLength()
    {
        return $this->getDivisionValue('FocalLength');
    }

    /**
     * @return null|string
     */
    public function getSoftware()
    {
        return $this->getSingleValue('Software');
    }

    /**
     * @return null|string
     */
    public function getLensModel()
    {
        return $this->getSingleValue('UndefinedTag:0xA434');
    }

    /**
     * @return null|string
     */
    public function getCameraSerialNumber()
    {
        return $this->getSingleValue('UndefinedTag:0xA431');
    }

    /**
     * @return null|string
     */
    public function getLensSerialNumber()
    {
        return $this->getSingleValue('UndefinedTag:0xA435');
    }

    /**
     * @return null|string
     */
    public function getCameraOwnerName()
    {
        return $this->getSingleValue('UndefinedTag:0xA430');
    }

    /**
     * @return null|string
     */
    public function getLensSpecification()
    {
        return $this->getValue('UndefinedTag:0xA432');
    }

    /**
     * @return null|string
     */
    public function getExposureCompensation()
    {
        return $this->getSingleValue('ExposureBiasValue');
    }

    /**
     * @return int|string
     */
    public function getApertureValue()
    {
        return $this->getDivisionValue('FNumber');
    }

    /**
     * @return null|string
     */
    public function getMeteringMode()
    {
        return $this->getSingleValue('MeteringMode');
    }

    /**
     * @return null|string
     */
    public function getShutterSpeed()
    {
        return $this->getSingleValue('ExposureTime');
    }

    public function getGPS()
    {

        /**
         * Taken from https://www.codexworld.com/get-geolocation-latitude-longitude-from-image-php/
         */

        $GPSLatitudeRef = $this->getValue('GPSLatitudeRef');
        $GPSLatitude    = $this->getValue('GPSLatitude') ? $this->getValue('GPSLatitude') : [];
        $GPSLongitudeRef= $this->getValue('GPSLongitudeRef');
        $GPSLongitude   = $this->getValue('GPSLongitude') ? $this->getValue('GPSLongitude') : [];

        $lat_degrees = count($GPSLatitude) > 0 ? $this->gps2Num($GPSLatitude[0]) : 0;
        $lat_minutes = count($GPSLatitude) > 1 ? $this->gps2Num($GPSLatitude[1]) : 0;
        $lat_seconds = count($GPSLatitude) > 2 ? $this->gps2Num($GPSLatitude[2]) : 0;

        $lon_degrees = count($GPSLongitude) > 0 ? $this->gps2Num($GPSLongitude[0]) : 0;
        $lon_minutes = count($GPSLongitude) > 1 ? $this->gps2Num($GPSLongitude[1]) : 0;
        $lon_seconds = count($GPSLongitude) > 2 ? $this->gps2Num($GPSLongitude[2]) : 0;

        $lat_direction = ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
        $lon_direction = ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;

        $latitude = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60 * 60)));
        $longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60 * 60)));

        $latitude_deg = sprintf('%s°%s\'%s" %s', $lat_degrees, $lat_minutes, $lat_seconds, $lat_direction == 1 ? 'N':'S');
        $longitude_deg = sprintf('%s°%s\'%s" %s', $lon_degrees, $lon_minutes, $lon_seconds, $lon_direction == 1 ? 'E':'W');

        return [
            'lat' => $latitude,
            'lon' => $longitude,
            'lat_deg' => $latitude_deg,
            'lon_deg' => $longitude_deg
        ];
    }

    private function gps2Num($coordPart)
    {
        $parts = explode('/', $coordPart);
        if (count($parts) <= 0) {
            return 0;
        }
        if (count($parts) == 1) {
            return $parts[0];
        }
        return floatval($parts[0]) / floatval($parts[1]);
    }


    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'gps' => $this->getGPS(),
            'camera' => [
                'make' => $this->getMake(),
                'model' => $this->getModel(),
                'serial_number' => $this->getCameraSerialNumber(),
                'owner' => $this->getCameraOwnerName(),
            ],
            'exposure' => $this->getExposure(),
            'exposure_compensation' => $this->getExposureCompensation(),
            'flash' => $this->getFlash(),
            'iso' => $this->getISO(),
            'resolution' => [
                'x' => $this->getResolutionX(),
                'y' => $this->getResolutionY(),
            ],
            'focal_length' => $this->getFocalLength(),
            'software' => $this->getSoftware(),
            'lens' => [
                'model' => $this->getLensModel(),
                'serial_number' => $this->getLensSerialNumber(),
                'specification' => $this->getLensSpecification(),
            ],
            'aperture' => $this->getApertureValue(),
            'metering' => $this->getMeteringMode(),
            'shutter' => $this->getShutterSpeed(),
        ];
    }
}
