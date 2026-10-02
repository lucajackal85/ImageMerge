<?php

namespace Jackal\ImageMerge\Test\FunctionalTest;

use Jackal\ImageMerge\ImageMerge;

class FlipTest extends ImageTestCase
{
    public function testFlipHorizontal()
    {
        $builder = ImageMerge::fromPath(__DIR__ . '/Resources/FlipTest/01.png');

        $builder->flipHorizontal();

        $this->assertPNGSameImage($builder->getImage(), __DIR__ . '/Resources/FlipTest/02.png');
    }

    public function testFlipVertical()
    {
        $builder = ImageMerge::fromPath(__DIR__ . '/Resources/FlipTest/01.png');

        $builder->flipVertical();

        $this->assertPNGSameImage($builder->getImage(), __DIR__ . '/Resources/FlipTest/03.png');
    }
}
