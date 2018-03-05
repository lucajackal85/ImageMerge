<?php


namespace Jackal\ImageMerge\Test\UnitTest\Strategy;


use Jackal\ImageMerge\Strategy\ImageBuilderURLStrategy;
use PHPUnit\Framework\TestCase;

class ImageBuilderURLStrategyTest extends TestCase
{
    public function testSupportHTTPPath(){

        $strategy = new ImageBuilderURLStrategy();

        $this->assertFalse($strategy->support('/local/path/to/image.png'));
        $this->assertTrue($strategy->support('http://path/to/image.png'));
    }
}