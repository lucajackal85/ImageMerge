<?php

namespace Jackal\ImageMerge\Test\UnitTest\ValueObject;

use Jackal\ImageMerge\ValueObject\Dimention;
use PHPUnit\Framework\TestCase;

class DimentionTest extends TestCase
{
    public function testThrowExceptionIfNoParams(){

        $this->setExpectedException('\InvalidArgumentException', 'Both width and height are empty values');
        $dimention = new Dimention(null, null);

    }

    public function testSetOnlyWidth(){

        $dimention = new Dimention(10, null);
        $this->assertEquals(10, $dimention->getWidth());
        $this->assertEquals(null, $dimention->getHeight());
    }

    public function testSetOnlyHeight(){

        $dimention = new Dimention(null, 20);
        $this->assertEquals(null, $dimention->getWidth());
        $this->assertEquals(20, $dimention->getHeight());
    }

    public function testNullonZeroValue(){
        $dimention = new Dimention(0, 20);
        $this->assertEquals(null, $dimention->getWidth());
        $this->assertEquals(20, $dimention->getHeight());
    }

}