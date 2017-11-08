<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 08/11/17
 * Time: 14.11
 */

namespace Jackal\ImageMerge\Test\UnitTest\Model;


use Jackal\ImageMerge\Model\Coordinate;
use PHPUnit\Framework\TestCase;

class CoordinateTest extends TestCase
{
    public function testCoordinateObject(){

        $coord = new Coordinate(10,20);

        $this->assertEquals($coord->getX(),10);
        $this->assertEquals($coord->getY(),20);

    }
}