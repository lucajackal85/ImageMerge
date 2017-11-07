<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 07/11/17
 * Time: 17.56
 */

namespace Jackal\ImageMerge\Test\Options;


use Jackal\ImageMerge\Command\Options\DoubleCoordinateColorCommandOption;
use PHPUnit\Framework\TestCase;

class DoubleCoordinateColorCommandOptionTest extends TestCase
{
    public function testDoubleCoordinateColorCommandOption(){

        $object = new DoubleCoordinateColorCommandOption(10,20,100,100,'ABCDEF');

        $this->assertEquals(10,$object->getX1());
        $this->assertEquals(20,$object->getY1());

        $this->assertEquals(100,$object->getX2());
        $this->assertEquals(100,$object->getY2());

        $this->assertEquals(239,$object->getColorBlue());
        $this->assertEquals(205,$object->getColorGreen());
        $this->assertEquals(171,$object->getColorRed());
    }
}