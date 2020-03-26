<?php

namespace Jackal\ImageMerge\Test\UnitTest\Utils;

use Jackal\ImageMerge\Command\Options\MultiCoordinateCommandOption;
use Jackal\ImageMerge\Utils\GeometryUtils;
use Jackal\ImageMerge\ValueObject\Coordinate;
use PHPUnit\Framework\TestCase;

class GeometryUtilsTest extends TestCase
{
    public function testCockwiseCoordsQuadtrato(){

        $coords = GeometryUtils::getClockwiseOrder(new MultiCoordinateCommandOption([
            new Coordinate(0, 0),
            new Coordinate(10, 10),
            new Coordinate(0, 10),
            new Coordinate(10, 0),
        ]));

        $array = $coords->getCoordinates();

        $this->assertEquals(0, $array[0]->getX());
        $this->assertEquals(0, $array[0]->getY());

        $this->assertEquals(10, $array[1]->getX());
        $this->assertEquals(0, $array[1]->getY());

        $this->assertEquals(10, $array[2]->getX());
        $this->assertEquals(10, $array[2]->getY());

        $this->assertEquals(0, $array[3]->getX());
        $this->assertEquals(10, $array[3]->getY());
    }

    public function testCockwiseCoordsQuadtrilatero1(){

        $coords = GeometryUtils::getClockwiseOrder(new MultiCoordinateCommandOption([
            new Coordinate(0, 1),
            new Coordinate(8, 0),
            new Coordinate(10, 10),
            new Coordinate(0, 9),

        ]));

        $array = $coords->toArray();
        $coordsArr = $coords->getCoordinates();
        $this->assertCount(8, $array);

        $this->assertEquals(0, $coordsArr[0]->getX());
        $this->assertEquals(1, $coordsArr[0]->getY());

        $this->assertEquals(8, $coordsArr[1]->getX());
        $this->assertEquals(0, $coordsArr[1]->getY());

        $this->assertEquals(10, $coordsArr[2]->getX());
        $this->assertEquals(10, $coordsArr[2]->getY());

        $this->assertEquals(0, $coordsArr[3]->getX());
        $this->assertEquals(9, $coordsArr[3]->getY());
    }

    public function testCloclWiseCoordsBug(){
        //94,66,136,67,167,559,89,556,
        $coords = GeometryUtils::getClockwiseOrder(new MultiCoordinateCommandOption([
            new Coordinate(94, 66),
            new Coordinate(136, 67),
            new Coordinate(167, 559),
            new Coordinate(89, 556),

        ]));

        $this->assertCount(8, $coords->toArray());
    }

    public function testCloclWiseCoordsBug2(){
        //94,66,136,67,167,559,89,556,
        $coords = GeometryUtils::getClockwiseOrder(new MultiCoordinateCommandOption([
            new Coordinate(1, 0),
            new Coordinate(0, 1),
            new Coordinate(9, 6),
            new Coordinate(6, 8),

        ]));

        $this->assertCount(8, $coords->toArray());

        $this->assertEquals(0, $coords->getCoordinates()[0]->getX());
        $this->assertEquals(1, $coords->getCoordinates()[0]->getY());

        $this->assertEquals(1, $coords->getCoordinates()[1]->getX());
        $this->assertEquals(0, $coords->getCoordinates()[1]->getY());

        $this->assertEquals(9, $coords->getCoordinates()[2]->getX());
        $this->assertEquals(6, $coords->getCoordinates()[2]->getY());

        $this->assertEquals(6, $coords->getCoordinates()[3]->getX());
        $this->assertEquals(8, $coords->getCoordinates()[3]->getY());

    }

    public function testCloclWiseCoordsBug3(){
        //94,66,136,67,167,559,89,556,
        $coords = GeometryUtils::getClockwiseOrder(new MultiCoordinateCommandOption([
            new Coordinate(2, 0),
            new Coordinate(6, 2),
            new Coordinate(3, 4),
            new Coordinate(0, 3),

        ]));

        $this->assertCount(8, $coords->toArray());

        $this->assertEquals(2, $coords->getCoordinates()[0]->getX());
        $this->assertEquals(0, $coords->getCoordinates()[0]->getY());

        $this->assertEquals(6, $coords->getCoordinates()[1]->getX());
        $this->assertEquals(2, $coords->getCoordinates()[1]->getY());

        $this->assertEquals(3, $coords->getCoordinates()[2]->getX());
        $this->assertEquals(4, $coords->getCoordinates()[2]->getY());

        $this->assertEquals(0, $coords->getCoordinates()[3]->getX());
        $this->assertEquals(3, $coords->getCoordinates()[3]->getY());

        $array = $coords->toArray();
        $this->assertCount(8, $array);
        $this->assertEquals(2, $array[0]);
        $this->assertEquals(0, $array[1]);
        $this->assertEquals(6, $array[2]);
        $this->assertEquals(2, $array[3]);
        $this->assertEquals(3, $array[4]);
        $this->assertEquals(4, $array[5]);
        $this->assertEquals(0, $array[6]);
        $this->assertEquals(3, $array[7]);
    }

    public function testCloclWiseCoordsBug4(){
        //94,66,136,67,167,559,89,556,
        $coords = GeometryUtils::getClockwiseOrder(new MultiCoordinateCommandOption([
            new Coordinate(0, 3),
            new Coordinate(5, 0),
            new Coordinate(6, 2),
            new Coordinate(3, 4),

        ]));

        $this->assertEquals(5, $coords->getCoordinates()[0]->getX());
        $this->assertEquals(0, $coords->getCoordinates()[0]->getY());

        $this->assertEquals(6, $coords->getCoordinates()[1]->getX());
        $this->assertEquals(2, $coords->getCoordinates()[1]->getY());

        $this->assertEquals(3, $coords->getCoordinates()[2]->getX());
        $this->assertEquals(4, $coords->getCoordinates()[2]->getY());

        $this->assertEquals(0, $coords->getCoordinates()[3]->getX());
        $this->assertEquals(3, $coords->getCoordinates()[3]->getY());

        $array = $coords->toArray();
        $this->assertCount(8, $array);
        $this->assertEquals(5, $array[0]);
        $this->assertEquals(0, $array[1]);
        $this->assertEquals(6, $array[2]);
        $this->assertEquals(2, $array[3]);
        $this->assertEquals(3, $array[4]);
        $this->assertEquals(4, $array[5]);
        $this->assertEquals(0, $array[6]);
        $this->assertEquals(3, $array[7]);
    }

    public function testItShoulReturnTop(){
        $coords = GeometryUtils::getTopCoord([
            new Coordinate(10, 67),
            new Coordinate(20, 66),
        ]);

        $this->assertEquals(20, $coords[0]->getX());
        $this->assertEquals(66, $coords[0]->getY());
    }

    public function testItShoulReturnBottom(){
        $coords = GeometryUtils::getBottomCoord([
            new Coordinate(10, 67),
            new Coordinate(20, 66),
        ]);

        $this->assertEquals(10, $coords[0]->getX());
        $this->assertEquals(67, $coords[0]->getY());
    }

    public function testItShoulReturnLeft(){
        $coords = GeometryUtils::getLeftCoord([
            new Coordinate(10, 67),
            new Coordinate(20, 66),
        ]);

        $this->assertEquals(10, $coords[0]->getX());
        $this->assertEquals(67, $coords[0]->getY());
    }

    public function testItShoulReturnRight(){

        $coords = GeometryUtils::getRightCoord([
            new Coordinate(20, 66),
            new Coordinate(10, 67),
        ]);

        $this->assertEquals(20, $coords[0]->getX());
        $this->assertEquals(66, $coords[0]->getY());
    }

    public function testItMatch(){
        $a = new Coordinate(10, 67);
        $b = new Coordinate(10, 67);

        $this->assertTrue($a->match($b));
    }
}