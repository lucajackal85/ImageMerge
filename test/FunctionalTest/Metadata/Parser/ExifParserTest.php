<?php

namespace Jackal\ImageMerge\Test\FunctionalTest\Metadata\Parser;

use Jackal\ImageMerge\Metadata\Parser\ExifParser;
use Jackal\ImageMerge\Model\File\FileObject;
use PHPUnit\Framework\TestCase;

class ExifParserTest extends TestCase
{
    public function testExifData()
    {
        $exif = new ExifParser(new FileObject(__DIR__ . '/../../Resources/ExifParserTest/01.jpg'));
        $exifArray = $exif->toArray();

        $this->assertEquals('Canon', $exif->getMake());
        $this->assertEquals('Canon EOS-1D X', $exif->getModel());
        $this->assertEquals(null, $exif->getCameraOwnerName());
        $this->assertEquals('048011000512', $exif->getCameraSerialNumber());

        $this->assertEquals([
            'make' => $exif->getMake(),
            'model' => $exif->getModel(),
            'serial_number' => $exif->getCameraSerialNumber(),
            'owner' => $exif->getCameraOwnerName()
        ], $exifArray['camera']);

        $this->assertEquals('1/1000', $exif->getExposure());
        $this->assertEquals($exif->getExposure(), $exifArray['exposure']);

        $this->assertEquals(8, $exif->getApertureValue());
        $this->assertEquals($exif->getApertureValue(), $exifArray['aperture']);

        $this->assertEquals(200, $exif->getFocalLength());
        $this->assertEquals($exif->getFocalLength(), $exifArray['focal_length']);

        $this->assertEquals(250, $exif->getISO());
        $this->assertEquals($exif->getISO(), $exifArray['iso']);

        $this->assertFalse($exif->isEmpty());

        $this->assertEquals(72, $exif->getResolutionX());
        $this->assertEquals(72, $exif->getResolutionY());
        $this->assertEquals([
            'x' => $exif->getResolutionX(),
            'y' => $exif->getResolutionY()
        ], $exifArray['resolution']);

        $this->assertEquals('Adobe Photoshop Lightroom 6.12 (Macintosh)', $exif->getSoftware());
        $this->assertEquals($exif->getSoftware(), $exifArray['software']);

        $this->assertEquals('EF70-200mm f/2.8L IS II USM', $exif->getLensModel());
        $this->assertEquals('0000c1b93f', $exif->getLensSerialNumber());
        $this->assertEquals(['70/1','200/1','0/0','0/0'], $exif->getLensSpecification());
        $this->assertEquals([
            'model' => $exif->getLensModel(),
            'serial_number' => $exif->getLensSerialNumber(),
            'specification' => $exif->getLensSpecification()
        ], $exifArray['lens']);


        $this->assertEquals('-1/3', $exif->getExposureCompensation());
        $this->assertEquals($exif->getExposureCompensation(), $exifArray['exposure_compensation']);

        $this->assertEquals('1/1000', $exif->getShutterSpeed());
        $this->assertEquals($exif->getShutterSpeed(), $exifArray['shutter']);

        $this->assertEquals(5, $exif->getMeteringMode());
        $this->assertEquals($exif->getMeteringMode(), $exifArray['metering']);
    }
}
