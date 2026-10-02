<?php

namespace Jackal\ImageMerge\Test\Options;

use Jackal\ImageMerge\Command\Options\CropCommandOption;
use Jackal\ImageMerge\ValueObject\Coordinate;
use Jackal\ImageMerge\ValueObject\Dimension;
use PHPUnit\Framework\TestCase;

class CropCommandOptionTest extends TestCase
{
    public function testCropCommandOption(): void
    {
        $object = new CropCommandOption(new Coordinate(10, 20), new Dimension(100, 120));

        $this->assertEquals(10, $object->getCoordinate1()->getX());
        $this->assertEquals(20, $object->getCoordinate1()->getY());

        $this->assertEquals(100, $object->getDimension()->getWidth());
        $this->assertEquals(120, $object->getDimension()->getHeight());
    }
}
