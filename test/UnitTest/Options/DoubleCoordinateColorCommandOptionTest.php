<?php

namespace Jackal\ImageMerge\Test\Options;

use Jackal\ImageMerge\Command\Options\DoubleCoordinateColorCommandOption;
use Jackal\ImageMerge\Model\Coordinate;
use PHPUnit\Framework\TestCase;

class DoubleCoordinateColorCommandOptionTest extends TestCase
{
    public function testDoubleCoordinateColorCommandOption()
    {
        $object = new DoubleCoordinateColorCommandOption(new Coordinate(10, 20), new Coordinate(100, 100), 'ABCDEF');

        $this->assertEquals(10, $object->getCoordinate1()->getX());
        $this->assertEquals(20, $object->getCoordinate1()->getY());

        $this->assertEquals(100, $object->getCoordinate2()->getX());
        $this->assertEquals(100, $object->getCoordinate2()->getY());

        $this->assertEquals(239, $object->getColor()->blue());
        $this->assertEquals(205, $object->getColor()->Green());
        $this->assertEquals(171, $object->getColor()->red());
    }
}
