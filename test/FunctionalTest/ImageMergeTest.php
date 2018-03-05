<?php


namespace Jackal\ImageMerge\Test\FunctionalTest;


use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\ImageMerge;
use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Model\Image;
use PHPUnit\Framework\TestCase;

class ImageMergeTest extends TestCase
{
    public function testItShouldCreaeFromFileObject(){

        $source = __DIR__ . '/../FunctionalTest/Resources/0.jpg';

        $imageMerge = new ImageMerge();
        $file = new FileObject($source);
        $imageBuilder = $imageMerge->getImageBuilder($file);

        $this->assertInstanceOf(ImageBuilder::class,$imageBuilder);
    }

    public function testItShouldCreateFromImage(){

        $source = __DIR__ . '/../FunctionalTest/Resources/0.jpg';

        $imageMerge = new ImageMerge();
        $image = Image::fromFile(new FileObject($source));
        $imageBuilder = $imageMerge->getImageBuilder($image);

        $this->assertInstanceOf(ImageBuilder::class,$imageBuilder);
    }

    public function testItShouldCreateFromContentString(){
        $source = __DIR__ . '/../FunctionalTest/Resources/0.jpg';

        $imageMerge = new ImageMerge();
        $content = file_get_contents($source);
        $imageBuilder = $imageMerge->getImageBuilder($content);

        $this->assertInstanceOf(ImageBuilder::class,$imageBuilder);
    }

    public function testItShouldCreateBuilderFromFilePathName(){

        $source = __DIR__ . '/../FunctionalTest/Resources/0.jpg';

        $imageMerge = new ImageMerge();
        $imageBuilder = $imageMerge->getImageBuilder($source);

        $this->assertInstanceOf(ImageBuilder::class,$imageBuilder);

    }

    public function testItShouldCreateBuilderFromURL(){

        $source = 'https://www.gstatic.com/webp/gallery3/1.sm.png';

        $imageMerge = new ImageMerge();
        $imageBuilder = $imageMerge->getImageBuilder($source);

        $this->assertInstanceOf(ImageBuilder::class,$imageBuilder);

    }
}