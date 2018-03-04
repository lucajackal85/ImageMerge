<?php

namespace Jackal\ImageMerge\Test\FunctionalTest\Metadata\Parser;

use Jackal\ImageMerge\Metadata\Parser\XMPParser;
use Jackal\ImageMerge\Model\File\FileObject;
use PHPUnit\Framework\TestCase;

class XMPParserTest extends TestCase
{
    public function testXMPData()
    {
        $xmp = new XMPParser(new FileObject(__DIR__ . '/../../Resources/0.jpg'));
        $xmpArray = $xmp->toArray();

        $this->assertEquals(["LAT Images\nemail: sales@latimages.com"], $xmp->getCopyrights());
        $this->assertEquals($xmp->getCopyrights(), $xmpArray['copyrights']);

        $this->assertEquals(['f1', 'formula 1', 'formula one', 'gp', 'Portrait', 'Helmets', 'Finish'], $xmp->getKeywords());
        $this->assertEquals($xmp->getKeywords(), $xmpArray['keywords']);

        $this->assertEquals(new \DateTime('2017-11-12 18:37:12'), $xmp->getCreationDateTime());
        $this->assertEquals($xmp->getCreationDateTime(), $xmpArray['created_at']);

        $this->assertEquals(null, $xmp->getCreator());
        $this->assertEquals($xmp->getCreator(), $xmpArray['created_by']);

        $this->assertEquals('andrewhone@gmail.com', $xmp->getCaptionWriter());
        $this->assertEquals($xmp->getCaptionWriter(), $xmpArray['caption']);

        $this->assertEquals([
            'prefs' => '0:0:0:009367',
            'pm_version' => 'PM5',
            'tagged' => false,
            'color_class' => 0
        ], $xmp->getPhotoMechanic());
        $this->assertEquals($xmp->getPhotoMechanic(), $xmpArray['photomechanic']);

        $this->assertEquals('Interlagos, Sao Paulo, Brazil.
Sunday 12 November 2017.
Sebastian Vettel, Ferrari SF70H, 1st Position, arrives in Parc Ferme.
World Copyright: Andy Hone/LAT Images 
ref: Digital Image _ONY9367', $xmp->getDescription());
        $this->assertEquals($xmp->getDescription(), $xmpArray['description']);

        $this->assertFalse($xmp->isEmpty());
    }
}
