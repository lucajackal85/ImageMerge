<?php

namespace Jackal\ImageMerge\Test\FunctionalTest;

use Jackal\ImageMerge\ImageMerge;
use Jackal\ImageMerge\Model\File\FileObject;

class SaveImageTest extends FunctionalTest
{
    public function testWebPImage(){

        if(!function_exists('imagewebp')){
            $this->markTestSkipped('imagewebp not supported');
        }

        $imageMerge = new ImageMerge();
        $builder = $imageMerge->getBuilder(new FileObject(__DIR__ . '/Resources/ImageTest/03.jpg'));

        $this->assertWebPSameImage($builder->getImage(), __DIR__ . '/Resources/ImageTest/03.webp');

    }
}