<?php

namespace Jackal\ImageMerge\Test\Options;

use Jackal\ImageMerge\Command\Options\BorderCommandOption;
use Jackal\ImageMerge\Model\Color;
use PHPUnit\Framework\TestCase;

class BorderCommandOptionTest extends TestCase
{
    public function testBorderCommandOption()
    {
        $object = new BorderCommandOption(1, new Color('ABCDEF'));

        $this->assertEquals(1, $object->getStroke());
        $this->assertEquals('ABCDEF', $object->getColor()->getHex());
    }
}
