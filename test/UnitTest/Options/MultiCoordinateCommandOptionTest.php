<?php

namespace Jackal\ImageMerge\Test\Options;

use Jackal\ImageMerge\Command\Options\MultiCoordinateCommandOption;
use Jackal\ImageMerge\ValueObject\Coordinate;
use PHPUnit\Framework\TestCase;

class MultiCoordinateCommandOptionTest extends TestCase
{
    public function testMultiCoordinateCommandOptionObject()
    {
        $object = new MultiCoordinateCommandOption([
            new Coordinate(10, 20),
            new Coordinate(100, 20),
            new Coordinate(10, 100),
            new Coordinate(100, 100)
        ]);

        $this->assertEquals(10, $object->toArray()[0]);
        $this->assertEquals(20, $object->toArray()[1]);

        $this->assertEquals(100, $object->toArray()[2]);
        $this->assertEquals(20, $object->toArray()[3]);

        $this->assertEquals(10, $object->toArray()[4]);
        $this->assertEquals(100, $object->toArray()[5]);

        $this->assertEquals(100, $object->toArray()[6]);
        $this->assertEquals(100, $object->toArray()[7]);

        $this->assertEquals(10, $object->getMinX());
        $this->assertEquals(100, $object->getMaxX());

        $this->assertEquals(20, $object->getMinY());
        $this->assertEquals(100, $object->getMaxY());
    }

    public function testIsQuadrilateral(){

        $object = new MultiCoordinateCommandOption([
            new Coordinate(10, 20),
            new Coordinate(100, 20),
            new Coordinate(10, 100),
            new Coordinate(100, 100)
        ]);

        $this->assertTrue($object->isQuadrilateral());
    }


    public function testIsNotQuadrilateral(){

        $object = new MultiCoordinateCommandOption([
            new Coordinate(10, 20),
            new Coordinate(100, 20),
            new Coordinate(10, 100)
        ]);

        $this->assertFalse($object->isQuadrilateral());
    }

    public function testToArray(){

        $object = new MultiCoordinateCommandOption([
            new Coordinate(10, 20),
            new Coordinate(100, 20),
            new Coordinate(10, 100),
            new Coordinate(100, 100)
        ]);

        $this->assertEquals([
            10,20,100,20,10,100,100,100
        ],$object->toArray());
    }

    public function testGetDimention(){

        $object = new MultiCoordinateCommandOption([
            new Coordinate(10, 20),
            new Coordinate(100, 20),
            new Coordinate(10, 100),
            new Coordinate(100, 100)
        ]);

        $this->assertEquals(90,$object->getCropDimention()->getWidth());
        $this->assertEquals(80,$object->getCropDimention()->getHeight());
    }
}
