<?php

namespace Jackal\ImageMerge\Test\UnitTest\ValueObject;

use Jackal\ImageMerge\ValueObject\Dimension;
use PHPUnit\Framework\TestCase;

class DimensionTest extends TestCase
{
    public function testThrowExceptionIfNoParams()
    {

        $this->expectException('\InvalidArgumentException');
        $this->expectExceptionMessage('Both width and height are empty values');
        $dimension = new Dimension(null, null);

    }

    public function testSetOnlyWidth()
    {

        $dimension = new Dimension(10, null);
        $this->assertEquals(10, $dimension->getWidth());
        $this->assertEquals(null, $dimension->getHeight());
    }

    public function testSetOnlyHeight()
    {

        $dimension = new Dimension(null, 20);
        $this->assertEquals(null, $dimension->getWidth());
        $this->assertEquals(20, $dimension->getHeight());
    }

    public function testNullonZeroValue()
    {
        $dimension = new Dimension(0, 20);
        $this->assertEquals(null, $dimension->getWidth());
        $this->assertEquals(20, $dimension->getHeight());
    }

}
