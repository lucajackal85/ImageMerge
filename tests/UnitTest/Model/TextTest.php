<?php

namespace Jackal\ImageMerge\Test\UnitTest\Model;

use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\Model\Font\Font;
use Jackal\ImageMerge\Model\Text\Text;
use PHPUnit\Framework\TestCase;

class TextTest extends TestCase
{
    public function testTextObject()
    {
        $text = new Text('this is a text', Font::arial(), 12, new Color('ABCDEF'));

        $this->assertEquals('this is a text', $text->getText());
        $this->assertEquals(Font::arial(), $text->getFont());
        $this->assertEquals(12, $text->getFontSize());
        $this->assertEquals('ABCDEF', $text->getColor()->getHex());
    }
}
