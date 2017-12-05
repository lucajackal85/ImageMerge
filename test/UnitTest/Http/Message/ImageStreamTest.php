<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 01/12/17
 * Time: 22:47
 */

namespace Jackal\ImageMerge\Test\UnitTest\Http\Message;


use Jackal\ImageMerge\Http\Message\ImageStream;
use PHPUnit\Framework\TestCase;

class ImageStreamTest extends TestCase
{
    public function testImageStream(){

        $imageStream = new ImageStream('this is the content');

        $this->assertEquals('this is the content',$imageStream->getContents());
        $this->assertEquals(19,$imageStream->getSize());
        $this->assertEquals(null,$imageStream->getMetadata());
        $this->assertTrue($imageStream->isReadable());
        $this->assertTrue($imageStream->isSeekable());
        $this->assertFalse($imageStream->isWritable());

        //read 10 bytes
        $this->assertEquals('this is th',$imageStream->read(10));
        $this->assertEquals(10,$imageStream->tell());
        //read another byte
        $this->assertEquals('e',$imageStream->read(1));
        $this->assertEquals(11,$imageStream->tell());

        //return to beginning
        $imageStream->seek(0);
        $this->assertEquals(0,$imageStream->tell());

        $this->assertFalse($imageStream->eof());

        //move to the end
        $imageStream->seek(19);
        $this->assertTrue($imageStream->eof());

    }

    public function testItShouldRaiseExceptionOnWrite(){

        $imageStream = new ImageStream('this is the content');

        $this->setExpectedException('\RuntimeException');
        $imageStream->write('ops...');

    }
}