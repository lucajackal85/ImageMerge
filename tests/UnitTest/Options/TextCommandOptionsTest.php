<?php

namespace Jackal\ImageMerge\Test\Options;

use Jackal\ImageMerge\Command\Options\TextCommandOption;
use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\ValueObject\Coordinate;
use Jackal\ImageMerge\Model\Font\Font;
use Jackal\ImageMerge\Model\Text\Text;
use PHPUnit\Framework\TestCase;

class TextCommandOptionsTest extends TestCase
{
    public function testTextCommandOptionsObject()
    {
        $text = new Text('this is a text', Font::arial(), 12, new Color('ABCDEF'));

        $object = new TextCommandOption($text, new Coordinate(10, 20));

        $this->assertEquals(10, $object->getCoordinate1()->getX());
        $this->assertEquals(20, $object->getCoordinate1()->getY());

        $this->assertEquals(239, $object->getColor()->blue());
        $this->assertEquals(205, $object->getColor()->Green());
        $this->assertEquals(171, $object->getColor()->red());
    }
}
