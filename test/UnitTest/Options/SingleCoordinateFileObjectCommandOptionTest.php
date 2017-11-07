<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 07/11/17
 * Time: 17.27
 */

namespace Jackal\ImageMerge\Test\Options;


use Jackal\ImageMerge\Command\Options\SingleCoordinateFileObjectCommandOption;
use PHPUnit\Framework\TestCase;

class SingleCoordinateFileObjectCommandOptionTest extends TestCase
{
    public function testSingleCoordinateFileObjectCommandOptionObject(){

        $mock = $this->getMockBuilder('\Jackal\ImageMerge\Model\File\FileInterface')->disableOriginalConstructor()->getMock();

        $object = new SingleCoordinateFileObjectCommandOption($mock,10,20);

        $this->assertEquals(10,$object->getX1());
        $this->assertEquals(20,$object->getY1());
        $this->assertEquals($mock,$object->getFileObject());

    }
}