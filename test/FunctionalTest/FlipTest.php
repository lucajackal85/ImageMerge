<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 28/11/17
 * Time: 23:32
 */

namespace Jackal\ImageMerge\Test\FunctionalTest;


use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Model\File\File;

class FlipTest extends FunctionalTest
{
    public function testFlipHorizontal(){
        $builder = ImageBuilder::fromFile(new File(__DIR__.'/Resources/image1.jpg'));

        $builder->flipHorizontal();

        $this->assertSameImage($builder->getImage(),__DIR__.'/Resources/image1_flip_h.jpg');
    }

    public function testFlipVertical(){
        $builder = ImageBuilder::fromFile(new File(__DIR__.'/Resources/image1.jpg'));

        $builder->flipVertical();

        $this->assertSameImage($builder->getImage(),__DIR__.'/Resources/image1_flip_v.jpg');
    }
}