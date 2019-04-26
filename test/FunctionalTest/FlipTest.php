<?php

namespace Jackal\ImageMerge\Test\FunctionalTest;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\ImageMerge;
use Jackal\ImageMerge\Model\File\FileObject;

class FlipTest extends FunctionalTest
{
    public function testFlipHorizontal()
    {
        $imageMerge = new ImageMerge();
        $builder = $imageMerge->getBuilder(new FileObject(__DIR__.'/Resources/FlipTest/01.png'));

        $builder->flipHorizontal();

        $this->assertPNGSameImage($builder->getImage(), __DIR__.'/Resources/FlipTest/02.png');
    }

    public function testFlipVertical()
    {
        $imageMerge = new ImageMerge();
        $builder = $imageMerge->getBuilder(new FileObject(__DIR__.'/Resources/FlipTest/01.png'));

        $builder->flipVertical();

        $this->assertPNGSameImage($builder->getImage(), __DIR__.'/Resources/FlipTest/03.png');
    }
}
