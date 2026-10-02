<?php

namespace Jackal\ImageMerge\Test\Options;

use Jackal\ImageMerge\Command\Options\SingleCoordinateFileObjectCommandOption;
use Jackal\ImageMerge\Model\File\FileObjectInterface;
use Jackal\ImageMerge\ValueObject\Coordinate;
use PHPUnit\Framework\TestCase;

class SingleCoordinateFileObjectCommandOptionTest extends TestCase
{
    public function testSingleCoordinateFileObjectCommandOptionObject(): void
    {
        $mock = $this->getMockBuilder(FileObjectInterface::class)->disableOriginalConstructor()->getMock();

        $object = new SingleCoordinateFileObjectCommandOption($mock, new Coordinate(10, 20));

        $this->assertEquals(10, $object->getCoordinate1()->getX());
        $this->assertEquals(20, $object->getCoordinate1()->getY());
        $this->assertEquals($mock, $object->getFile());
    }
}
