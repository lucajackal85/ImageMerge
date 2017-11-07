<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 03/11/17
 * Time: 20.48
 */

namespace Jackal\ImageMerge\Test\FunctionalTest;


use Jackal\ImageMerge\Model\Font\Font;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\Model\Text\Text;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{

    public function testMergeFromString(){

        $image = Image::fromString(file_get_contents(__DIR__.'/Resources/image1.jpg'));
        $text = new Text('questo è un testo',Font::arial(),16,'000000');
        $image->addText($text,20,20);
        $image->merge(Image::fromFile(new \SplFileObject(__DIR__.'/Resources/image2.jpg')),30,40);

        $this->compareImages($image,__DIR__.'/Resources/final_image.png');

    }

    public function testMergeFromFile(){

        $image = Image::fromFile(new\SplFileObject(__DIR__.'/Resources/image1.jpg'));
        $text = new Text('questo è un testo',Font::arial(),16,'000000');
        $image->addText($text,20,20);
        $image->merge(Image::fromFile(new \SplFileObject(__DIR__.'/Resources/image2.jpg')),30,40);

        $this->compareImages($image,__DIR__.'/Resources/final_image.png');
    }

    private function compareImages(Image $image,$imagePathnameToCompare){

        $this->assertEquals(file_get_contents($imagePathnameToCompare),$image->toPNG());
    }
}