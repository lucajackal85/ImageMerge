<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 07/11/17
 * Time: 17.27
 */

namespace Jackal\ImageMerge\Test\Options;


use Jackal\ImageMerge\Command\Options\SingleCoordinateFileObjectCommandOption;
use Jackal\ImageMerge\Model\Coordinate;
use PHPUnit\Framework\TestCase;

class SingleCoordinateFileObjectCommandOptionTest extends TestCase
{
    public function testSingleCoordinateFileObjectCommandOptionObject(){

        $mock = $this->getMockBuilder('\Jackal\ImageMerge\Model\File\FileObjectInterface')->disableOriginalConstructor()->getMock();

        $object = new SingleCoordinateFileObjectCommandOption($mock,new Coordinate(10,20));

        $this->assertEquals(10,$object->getCoordinate1()->getX());
        $this->assertEquals(20,$object->getCoordinate1()->getY());
        $this->assertEquals($mock,$object->getFile());

    }
}