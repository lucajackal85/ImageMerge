<?php

namespace Jackal\ImageMerge\Test\Options;

use Jackal\ImageMerge\Command\Options\BorderCommandOption;
use PHPUnit\Framework\TestCase;

class BorderCommandOptionTest extends TestCase
{
    public function testBorderCommandOption()
    {
        $object = new BorderCommandOption(1, 'ABCDEF');

        $this->assertEquals(1, $object->getStroke());
        $this->assertEquals('ABCDEF', $object->getColors());
    }
}
