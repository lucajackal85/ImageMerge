<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 08/11/17
 * Time: 12.51
 */

namespace Jackal\ImageMerge\Test\UnitTest\Model;


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
}