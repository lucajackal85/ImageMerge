<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 25/11/17
 * Time: 12:17
 */

namespace Jackal\ImageMerge\Test\FunctionalTest\Metadata\Parser;


use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Metadata\Parser\ExifParser;
use Jackal\ImageMerge\Model\File\File;
use PHPUnit\Framework\TestCase;

class ExifParserTest extends TestCase
{
    public function testExifData(){
        $exif = new ExifParser(new File(__DIR__ . '/../../Resources/0.jpg'));

        $this->assertEquals('Canon',$exif->getMake());
        $this->assertEquals('Canon EOS-1D X',$exif->getModel());
        $this->assertEquals('1/1000',$exif->getExposure());
        //$this->assertEquals(8,$image->getImage()->getMetadata()->getCameraAperture());
        $this->assertEquals(200,$exif->getFocalLength());
        $this->assertEquals(250,$exif->getISO());
        $this->assertFalse($exif->isEmpty());

        $this->assertEquals(72,$exif->getResolutionX());
        $this->assertEquals(72,$exif->getResolutionY());

        $this->assertEquals('Adobe Photoshop Lightroom 6.12 (Macintosh)',$exif->getSoftware());

        $this->assertEquals('EF70-200mm f/2.8L IS II USM',$exif->getLensModel());

        $this->assertEquals('-1/3',$exif->getExposureCompensation());
        $this->assertEquals('048011000512',$exif->getCameraSerialNumber());
        $this->assertEquals('0000c1b93f',$exif->getLensSerialNumber());
        $this->assertEquals('1/1000',$exif->getShutterSpeed());
        $this->assertEquals(8,$exif->getApertureValue());
        $this->assertEquals(5,$exif->getMeteringMode());

        $this->assertEquals(null,$exif->getCameraOwnerName());
        $this->assertEquals([
            '70/1','200/1','0/0','0/0'
        ],$exif->getLensSpecification());
    }
}