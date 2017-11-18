<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 10/11/17
 * Time: 9.13
 */

namespace Jackal\ImageMerge\Test\FunctionalTest;


use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Model\File\File;
use PHPUnit\Framework\TestCase;

class ExifTest extends TestCase
{
    public function testExifData(){
        $image = ImageBuilder::fromFile(new File(__DIR__.'/Resources/0.jpg'));
        $this->assertEquals('Canon',$image->getImage()->getMetadata()->getCameraMake());
        $this->assertEquals('Canon EOS-1D X',$image->getImage()->getMetadata()->getCameraModel());
        $this->assertEquals('1/1000',$image->getImage()->getMetadata()->getCameraExposure());
        //$this->assertEquals(8,$image->getImage()->getMetadata()->getCameraAperture());
        $this->assertEquals(200,$image->getImage()->getMetadata()->getCameraFocalLength());
        $this->assertEquals(250,$image->getImage()->getMetadata()->getCameraISO());
        //$this->assertEquals(false,$image->getImage()->getMetadata()->getCameraFlash());
    }
}