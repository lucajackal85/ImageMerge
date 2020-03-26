<?php

namespace Jackal\ImageMerge\Test\UnitTest\Strategy;

use Jackal\ImageMerge\Strategy\ImageBuilderFileStrategy;
use PHPUnit\Framework\TestCase;

class ImageBuilderFileStrategyTest extends TestCase
{
    public function testSupportFilePath(){

        $strategy = new ImageBuilderFileStrategy();

        $filePath = __DIR__ . '/../Resources/StrategyTest/01.jpg';
        $content = file_get_contents($filePath);

        $this->assertTrue($strategy->support($filePath));
        $this->assertFalse($strategy->support($content));
        $this->assertFalse($strategy->support('http://path/to/image.png'));

    }
}