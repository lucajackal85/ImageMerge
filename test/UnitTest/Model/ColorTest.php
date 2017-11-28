<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 08/11/17
 * Time: 12.51
 */

namespace Jackal\ImageMerge\Test\UnitTest\Model;


use Jackal\ImageMerge\Exception\InvalidColorException;
use Jackal\ImageMerge\Model\Color;
use PHPUnit\Framework\TestCase;

class ColorTest extends TestCase
{
    public function testColorProperties(){

        $color = new Color('ABCDEF');

        $this->assertEquals(239,$color->blue());
        $this->assertEquals(205,$color->green());
        $this->assertEquals(171,$color->red());
    }

    public function testColor3Digits(){

        $color = new Color('ABC');

        $this->assertEquals(204,$color->blue());
        $this->assertEquals(187,$color->green());
        $this->assertEquals(170,$color->red());
    }

    public function testRaiseExceptionOnInvalidColorFormat(){

        $this->setExpectedException(InvalidColorException::class);

        $this->setExpectedException(
            InvalidColorException::class,
            'Color "invalid" is invalid'
        );

        new Color('invalid');
    }

    public function testRaiseExceptionOnPartialInvalidColorFormat(){

        $this->setExpectedException(
            InvalidColorException::class,
            'Color "AABBCX" is invalid'
        );

        new Color('AABBCX');
    }
}