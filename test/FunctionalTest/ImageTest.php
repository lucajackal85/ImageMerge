<?php

namespace Jackal\ImageMerge\Test\FunctionalTest;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Command\Effect\EffectBlurCentered;
use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Model\Font\Font;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\Model\Text\Text;

class ImageTest extends FunctionalTest
{
    public function testAddEffects()
    {
        $builder = new ImageBuilder(new FileObject(__DIR__.'/Resources/image1.jpg'));
        $builder
            ->addSquare(10, 10, 20, 20, 'ABCDEF')
            ->addText(new Text('this is the text', Font::arial(), 12, 'ABCDEF'), 10, 20)
            ->thumbnail(100, 100)
            ->grayScale()
            ->brightness(10)
            ->blur(20)
            ->pixelate(10)
            ->crop(10, 10, 90, 90)
            ->resize(50, 50)
            ->cropCenter(40, 40)
            ->rotate(90)
            ->border(1);

        $builder->addCommand(EffectBlurCentered::class, new DimensionCommandOption(200, 200));

        $this->assertPNGSameImage($builder->getImage(), __DIR__.'/Resources/test.png');
    }

    public function testTrasparencyImage()
    {
        $builder = new ImageBuilder(new FileObject(__DIR__.'/Resources/image2.jpg'));
        $builder->merge(Image::fromFile(new FileObject(__DIR__.'/Resources/trasparent.png')));
        $builder->crop(0, 0, 200, 200);

        $this->assertPNGSameImage($builder->getImage(), __DIR__.'/Resources/test_trasparency.png');
    }
}
