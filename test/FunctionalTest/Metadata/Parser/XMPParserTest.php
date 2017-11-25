<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 10/11/17
 * Time: 9.13
 */

namespace Jackal\ImageMerge\Test\FunctionalTest\Metadata\Parser;


use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Metadata\Parser\XMPParser;
use Jackal\ImageMerge\Model\File\File;
use PHPUnit\Framework\TestCase;

class XMPParserTest extends TestCase
{

    public function testXMPData(){
        $xmp = new XMPParser(new File(__DIR__ . '/../../Resources/0.jpg'));
        $this->assertEquals(
            ["LAT Images\nemail: sales@latimages.com"],
            $xmp->getCopyrights()
        );

        $this->assertEquals(
            ['f1', 'formula 1', 'formula one', 'gp', 'Portrait', 'Helmets', 'Finish'],
            $xmp->getKeywords()
        );

        $this->assertEquals(
            new \DateTime('2017-11-12 18:37:12'),
            $xmp->getCreationDateTime()
        );

        $this->assertEquals(null,$xmp->getCreator());

        $this->assertFalse($xmp->isEmpty());

        $this->assertEquals('andrewhone@gmail.com',$xmp->getCaptionWriter());

        $this->assertEquals([
            'prefs' => '0:0:0:009367',
            'pm_version' => 'PM5',
            'tagged' => false,
            'color_class' => 0
        ],$xmp->getPhotoMechanic());

        $this->assertEquals('Interlagos, Sao Paulo, Brazil.
Sunday 12 November 2017.
Sebastian Vettel, Ferrari SF70H, 1st Position, arrives in Parc Ferme.
World Copyright: Andy Hone/LAT Images 
ref: Digital Image _ONY9367',$xmp->getDescription());
    }
}