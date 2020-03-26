<?php

namespace Jackal\ImageMerge\Test\Options;

use Jackal\ImageMerge\Command\Options\CropCommandOption;
use Jackal\ImageMerge\ValueObject\Coordinate;
use Jackal\ImageMerge\ValueObject\Dimention;
use PHPUnit\Framework\TestCase;

class CropCommandOptionTest extends TestCase
{
    public function testCropCommandOption()
    {
        $object = new CropCommandOption(new Coordinate(10, 20), new Dimention(100, 120));

        $this->assertEquals(10, $object->getCoordinate1()->getX());
        $this->assertEquals(20, $object->getCoordinate1()->getY());

        $this->assertEquals(100, $object->getDimention()->getWidth());
        $this->assertEquals(120, $object->getDimention()->getHeight());
    }
}
