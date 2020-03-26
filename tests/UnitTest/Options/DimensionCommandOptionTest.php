<?php

namespace Jackal\ImageMerge\Test\Options;

use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\ValueObject\Dimention;
use PHPUnit\Framework\TestCase;

class DimensionCommandOptionTest extends TestCase
{
    public function testDimensionCommandOption()
    {
        $object = new DimensionCommandOption(new Dimention(10, 20));

        $this->assertEquals(10, $object->getDimention()->getWidth());
        $this->assertEquals(20, $object->getDimention()->getHeight());
    }
}
