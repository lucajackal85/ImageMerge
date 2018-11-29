<?php


namespace Jackal\ImageMerge\Test\UnitTest\Format;


use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Model\Format\ImageReader;
use PHPUnit\Framework\TestCase;

class ImageReaderTest extends TestCase
{
    public function testReadJPG(){

        $ir = ImageReader::fromPathname(new FileObject(__DIR__.'/../../FunctionalTest/Resources/0.jpg'));

        $this->assertEquals(ImageReader::FORMAT_JPG,$ir->getFormat());
    }

    public function testReadPNG(){

        $ir = ImageReader::fromPathname(new FileObject(__DIR__.'/../../FunctionalTest/Resources/building_pers.png'));

        $this->assertEquals(ImageReader::FORMAT_PNG,$ir->getFormat());
    }

    public function testReadGIF(){

        $ir = ImageReader::fromPathname(new FileObject(__DIR__.'/../../FunctionalTest/Resources/sample.gif'));

        $this->assertEquals(ImageReader::FORMAT_GIF,$ir->getFormat());
    }

    public function testReadWEBP(){

        $ir = ImageReader::fromPathname(new FileObject(__DIR__.'/../../FunctionalTest/Resources/200w.webp'));

        $this->assertEquals(ImageReader::FORMAT_WEBP,$ir->getFormat());
    }

    public function expectExceptionOnInvalidFile(){

        $this->setExpectedException('\Exception','File is not a valid image type [extension: "php", returned: ""]');
        $ir = ImageReader::fromPathname(new FileObject(__FILE__));
    }
}