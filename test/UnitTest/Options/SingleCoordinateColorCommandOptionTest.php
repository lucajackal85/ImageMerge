<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 07/11/17
 * Time: 17.38
 */

namespace Jackal\ImageMerge\Test\Options;


use Jackal\ImageMerge\Command\Options\SingleCoordinateColorCommandOption;
use PHPUnit\Framework\TestCase;

class SingleCoordinateColorCommandOptionTest extends TestCase
{
    public function testSingleCoordinateColorCommandOptionObject(){

        $object = new SingleCoordinateColorCommandOption(10,20,'ABCDEF');

        $this->assertEquals(10,$object->getX1());
        $this->assertEquals(20,$object->getY1());

        $this->assertEquals(239,$object->getColorBlue());
        $this->assertEquals(205,$object->getColorGreen());
        $this->assertEquals(171,$object->getColorRed());

    }
}