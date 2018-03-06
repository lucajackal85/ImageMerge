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
            new Coordinate(0,0),
            new Coordinate(10,10),
            new Coordinate(0,10),
            new Coordinate(10,0)
        ]));

        $array = $coords->getCoordinates();

        $this->assertEquals(0,$array[0]);
        $this->assertEquals(0,$array[1]);

        $this->assertEquals(10,$array[2]);
        $this->assertEquals(10,$array[3]);

        $this->assertEquals(0,$array[4]);
        $this->assertEquals(10,$array[5]);

        $this->assertEquals(10,$array[6]);
        $this->assertEquals(0,$array[7]);
    }

    public function testCockwiseCoordsQuadtrilatero1(){

        $coords = GeometryUtils::getClockwiseOrder(new MultiCoordinateCommandOption([
            new Coordinate(0,1),
            new Coordinate(8,0),
            new Coordinate(10,10),
            new Coordinate(0,9)

        ]));

        $array = $coords->getCoordinates();

        $this->assertEquals(0,$array[0]);
        $this->assertEquals(1,$array[1]);

        $this->assertEquals(8,$array[2]);
        $this->assertEquals(0,$array[3]);

        $this->assertEquals(10,$array[4]);
        $this->assertEquals(10,$array[5]);

        $this->assertEquals(0,$array[6]);
        $this->assertEquals(9,$array[7]);
    }
}