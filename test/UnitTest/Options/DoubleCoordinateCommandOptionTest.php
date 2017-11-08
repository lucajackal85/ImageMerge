<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 07/11/17
 * Time: 17.54
 */

namespace Jackal\ImageMerge\Test\Options;


use Jackal\ImageMerge\Command\Options\DoubleCoordinateCommandOption;
use Jackal\ImageMerge\Model\Coordinate;
use PHPUnit\Framework\TestCase;

class DoubleCoordinateCommandOptionTest extends TestCase
{
    public function testDoubleCoordinateCommandOptionObject(){

        $object = new DoubleCoordinateCommandOption(new Coordinate(10,20),new Coordinate(100,100));

        $this->assertEquals(10,$object->getCoordinate1()->getX());
        $this->assertEquals(20,$object->getCoordinate1()->getY());

        $this->assertEquals(100,$object->getCoordinate2()->getX());
        $this->assertEquals(100,$object->getCoordinate2()->getY());
    }
}