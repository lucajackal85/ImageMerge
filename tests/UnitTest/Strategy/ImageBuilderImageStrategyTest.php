<?php

namespace Jackal\ImageMerge\Test\UnitTest\Strategy;

use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\Strategy\ImageBuilderImageStrategy;
use PHPUnit\Framework\TestCase;

class ImageBuilderImageStrategyTest extends TestCase
{
    public function testSupportImage(){

        $strategy = new ImageBuilderImageStrategy();

        $filePath = __DIR__ . '/../Resources/StrategyTest/01.jpg';
        $image = Image::fromFile(new FileObject($filePath));

        $this->assertTrue($strategy->support($image));
    }
}