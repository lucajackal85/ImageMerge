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
        $builder = $imageMerge->getBuilder(new FileObject(__DIR__.'/Resources/image1.jpg'));

        $builder->flipHorizontal();

        $this->assertPNGSameImage($builder->getImage(), __DIR__.'/Resources/image1_flip_h.png');
    }

    public function testFlipVertical()
    {
        $imageMerge = new ImageMerge();
        $builder = $imageMerge->getBuilder(new FileObject(__DIR__.'/Resources/image1.jpg'));

        $builder->flipVertical();

        $this->assertPNGSameImage($builder->getImage(), __DIR__.'/Resources/image1_flip_v.png');
    }
}
