<?php

namespace Jackal\ImageMerge\Test\UnitTest\Strategy;

use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\Strategy\ImageBuilderResourceStrategy;
use PHPUnit\Framework\TestCase;

class ImageBuilderResourceStrategyTest extends TestCase
{
    public function testSupportResource(){

        $strategy = new ImageBuilderResourceStrategy();

        $filePath = __DIR__ . '/../Resources/StrategyTest/01.jpg';
        $image = Image::fromFile(new FileObject($filePath));

        $this->assertTrue($strategy->support($image->getResource()));
    }
}