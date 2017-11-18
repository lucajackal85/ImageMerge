<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 03/11/17
 * Time: 20.48
 */

namespace Jackal\ImageMerge\Test\FunctionalTest;


use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Command\Effect\EffectBlurCentered;
use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Model\Coordinate;
use Jackal\ImageMerge\Model\File\File;
use Jackal\ImageMerge\Model\Font\Font;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\Model\Text\Text;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{

    public function testMergeFromString(){

        $builder = ImageBuilder::fromString(file_get_contents(__DIR__.'/Resources/image1.jpg'));

        $text = new Text('questo è un testo',Font::arial(),16,'000000');
        $builder->addText($text,20,20);
        $builder->merge(Image::fromFile(new File(__DIR__.'/Resources/image2.jpg')),30,40);

        $this->compareImages($builder->getImage(),__DIR__.'/Resources/final_image.png');

    }

    public function testMergeFromFile(){

        $builder = ImageBuilder::fromFile(new File(__DIR__.'/Resources/image1.jpg'));

        $text = new Text('questo è un testo',Font::arial(),16,'000000');
        $builder->addText($text,20,20);
        $builder->merge(Image::fromFile(new File(__DIR__.'/Resources/image2.jpg')),30,40);

        $this->compareImages($builder->getImage(),__DIR__.'/Resources/final_image.png');
    }

    public function testAddEffects(){
        $builder = ImageBuilder::fromFile(new File(__DIR__.'/Resources/image1.jpg'));
        $builder
            ->addSquare(10,10,20,20,'ABCDEF')
            ->addText(new Text('this is the text',Font::arial(),12,'ABCDEF'),10,20)
            ->thumbnail(100,100)
            ->grayScale()
            ->brightness(10)
            ->blur(20)
            ->pixelate(10)
            ->crop(10,10,90,90)
            ->resize(50,50)
            ->cropCenter(40,40)
            ->rotate(90)
            ->border(1);

        $builder->addCommand(EffectBlurCentered::class,new DimensionCommandOption(200,200));

        $this->compareImages($builder->getImage(),__DIR__.'/Resources/test.png');

    }

    private function compareImages(Image $image,$imagePathnameToCompare){

        $this->assertEquals(file_get_contents($imagePathnameToCompare),$image->toPNG());
    }
}