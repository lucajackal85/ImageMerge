<?php


namespace Jackal\ImageMerge\Test\UnitTest\Strategy;


use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Strategy\ImageBuilderFileObjectStrategy;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;

class ImageBuilderFileObjectStrategyTest extends TestCase
{
    public function testSupportFileObject(){

        $strategy = new ImageBuilderFileObjectStrategy();

        $fileObject = new FileObject(__DIR__.'/../Resources/StrategyTest/01.jpg');

        $this->assertTrue($strategy->support($fileObject));
    }
}