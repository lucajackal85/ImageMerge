<?php

namespace Jackal\ImageMerge\Test\UnitTest\Model;

use Jackal\ImageMerge\Exception\InvalidColorException;
use Jackal\ImageMerge\Model\Color;
use PHPUnit\Framework\TestCase;

class ColorTest extends TestCase
{
    /**
     * @throws InvalidColorException
     */
    public function testColorProperties(): void
    {
        $color = new Color('ABCDEF');

        $this->assertEquals(239, $color->blue());
        $this->assertEquals(205, $color->green());
        $this->assertEquals(171, $color->red());
    }

    public function testColor3Digits(): void
    {
        $color = new Color('ABC');

        $this->assertEquals(204, $color->blue());
        $this->assertEquals(187, $color->green());
        $this->assertEquals(170, $color->red());
    }

    public function testRaiseExceptionOnInvalidColorFormat(): void
    {
        $this->expectException(InvalidColorException::class);
        $this->expectExceptionMessage('Color "invalid" is invalid');

        new Color('invalid');
    }

    public function testRaiseExceptionOnPartialInvalidColorFormat(): void
    {
        $this->expectException(InvalidColorException::class);
        $this->expectExceptionMessage('Color "AABBCX" is invalid');

        new Color('AABBCX');
    }
}
