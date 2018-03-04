<?php

namespace Jackal\ImageMerge\Test\Options;

use Jackal\ImageMerge\Command\Options\SingleCoordinateColorCommandOption;
use Jackal\ImageMerge\Model\Coordinate;
use PHPUnit\Framework\TestCase;

class SingleCoordinateColorCommandOptionTest extends TestCase
{
    public function testSingleCoordinateColorCommandOptionObject()
    {
        $object = new SingleCoordinateColorCommandOption(new Coordinate(10, 20), 'ABCDEF');

        $this->assertEquals(10, $object->getCoordinate1()->getX());
        $this->assertEquals(20, $object->getCoordinate1()->getY());

        $this->assertEquals(239, $object->getColor()->blue());
        $this->assertEquals(205, $object->getColor()->Green());
        $this->assertEquals(171, $object->getColor()->red());
    }
}
