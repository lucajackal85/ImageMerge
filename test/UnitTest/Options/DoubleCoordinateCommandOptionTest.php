<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 07/11/17
 * Time: 17.54
 */

namespace Jackal\ImageMerge\Test\Options;


use Jackal\ImageMerge\Command\Options\DoubleCoordinateCommandOption;
use PHPUnit\Framework\TestCase;

class DoubleCoordinateCommandOptionTest extends TestCase
{
    public function testDoubleCoordinateCommandOptionObject(){

        $object = new DoubleCoordinateCommandOption(10,20,100,100);

        $this->assertEquals(10,$object->getX1());
        $this->assertEquals(20,$object->getY1());

        $this->assertEquals(100,$object->getX2());
        $this->assertEquals(100,$object->getY2());
    }
}