<?php


namespace Jackal\ImageMerge\Test\UnitTest\Strategy;


use Jackal\ImageMerge\Strategy\ImageBuilderContentStrategy;
use PHPUnit\Framework\TestCase;

class ImageBuilderContentStrategyTest extends TestCase
{
    public function testSupportContentString(){

        $filePath = __DIR__.'/../Resources/StrategyTest/01.jpg';
        $content = file_get_contents($filePath);

        $strategy = new ImageBuilderContentStrategy();

        $this->assertTrue($strategy->support($content));
        $this->assertFalse($strategy->support($filePath));
    }
}