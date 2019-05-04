<?php

namespace Jackal\ImageMerge\Test\FunctionalTest;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Command\Effect\EffectBlurCentered;
use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\ImageMerge;
use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Model\Font\Font;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\Model\Text\Text;
use Jackal\ImageMerge\ValueObject\Dimention;

class ImageTest extends FunctionalTest
{
    public function testAddEffects()
    {
        $this->markTestSkipped('imagettftext not installed on Travis');

        $imageMerge = new ImageMerge();
        $builder = $imageMerge->getBuilder(new FileObject(__DIR__.'/Resources/ImageTest/01.jpg'));
        $builder
            ->addSquare(10, 10, 20, 20, 'ABCDEF')
            ->addText(new Text('this is the text', Font::arial(), 12, new Color('ABCDEF')), 10, 20)
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

        $builder->addCommand(new EffectBlurCentered(new DimensionCommandOption(new Dimention(200, 200))));

        $builder->getImage()->toPNG(__DIR__.'/Resources/00.png');
        $this->assertPNGSameImage($builder->getImage(), __DIR__.'/Resources/ImageTest/02.png');
    }

    public function testTrasparencyImage()
    {
        $imageMerge = new ImageMerge();

        $builder = $imageMerge->getBuilder(new FileObject(__DIR__.'/Resources/ImageTest/03.jpg'));
        $builder->merge(Image::fromFile(new FileObject(__DIR__.'/Resources/ImageTest/04.png')));
        $builder->crop(0, 0, 200, 200);

        $this->assertPNGSameImage($builder->getImage(), __DIR__.'/Resources/ImageTest/05.png');
    }

    protected function tearDown()
    {
        parent::tearDown();
        if(is_file(__DIR__.'/Resources/00.png')){
            unlink(__DIR__.'/Resources/00.png');
        }
    }


}
