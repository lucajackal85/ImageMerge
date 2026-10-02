<?php

namespace Jackal\ImageMerge\Test\UnitTest\Model;

use Jackal\ImageMerge\ValueObject\Coordinate;
use PHPUnit\Framework\TestCase;

class CoordinateTest extends TestCase
{
    public function testCoordinateObject(): void
    {
        $coord = new Coordinate(10, 20);

        $this->assertEquals($coord->getX(), 10);
        $this->assertEquals($coord->getY(), 20);
    }

    public function testCoordinateToArray(): void
    {

        $coord = new Coordinate(10, 20);

        $this->assertEquals([10,20], $coord->toArray());
    }
}
