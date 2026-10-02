<?php

namespace Jackal\ImageMerge\Test\Options;

use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\ValueObject\Dimension;
use PHPUnit\Framework\TestCase;

class DimensionCommandOptionTest extends TestCase
{
    public function testDimensionCommandOption(): void
    {
        $object = new DimensionCommandOption(new Dimension(10, 20));

        $this->assertEquals(10, $object->getDimension()->getWidth());
        $this->assertEquals(20, $object->getDimension()->getHeight());
    }
}
