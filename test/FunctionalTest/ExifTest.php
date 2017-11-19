<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 10/11/17
 * Time: 9.13
 */

namespace Jackal\ImageMerge\Test\FunctionalTest;


use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Model\File\File;
use PHPUnit\Framework\TestCase;

class ExifTest extends TestCase
{
    public function testExifData(){
        $image = ImageBuilder::fromFile(new File(__DIR__.'/Resources/0.jpg'));
        $this->assertEquals('Canon',$image->getImage()->getMetadata()->getExif()['make']);
        $this->assertEquals('Canon EOS-1D X',$image->getImage()->getMetadata()->getExif()['model']);
        $this->assertEquals('1/1000',$image->getImage()->getMetadata()->getExif()['exposure']);
        //$this->assertEquals(8,$image->getImage()->getMetadata()->getCameraAperture());
        $this->assertEquals(200,$image->getImage()->getMetadata()->getExif()['focal_length']);
        $this->assertEquals(250,$image->getImage()->getMetadata()->getExif()['iso']);
        //$this->assertEquals(false,$image->getImage()->getMetadata()->getCameraFlash());
    }

    public function testXMPData(){
        $image = ImageBuilder::fromFile(new File(__DIR__.'/Resources/0.jpg'));
        $this->assertEquals(
            ["LAT Images\nemail: sales@latimages.com"],
            $image->getImage()->getMetadata()->getXMP()['rights']
        );

        $this->assertEquals(
            ['f1', 'formula 1', 'formula one', 'gp', 'Portrait', 'Helmets', 'Finish'],
            $image->getImage()->getMetadata()->getXMP()['keywords']
        );

        $this->assertEquals(
            new \DateTime('2017-11-12 18:37:12'),
            $image->getImage()->getMetadata()->getXMP()['created_at']
        );

        $this->assertEquals('Interlagos, Sao Paulo, Brazil.
Sunday 12 November 2017.
Sebastian Vettel, Ferrari SF70H, 1st Position, arrives in Parc Ferme.
World Copyright: Andy Hone/LAT Images 
ref: Digital Image _ONY9367',$image->getImage()->getMetadata()->getXMP()['description'][0]);
    }
}