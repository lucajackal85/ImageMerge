<?php

namespace Jackal\ImageMerge\Test\FunctionalTest\Metadata\Parser;

use Jackal\ImageMerge\Metadata\Parser\XMPParser;
use Jackal\ImageMerge\Model\File\FileObject;
use PHPUnit\Framework\TestCase;

class XMPParserTest extends TestCase
{
    public function testXMPData(): void
    {
        $xmp = new XMPParser(new FileObject(__DIR__ . '/../../../Fixtures/photo-with-metadata.jpg'));
        $xmpArray = $xmp->toArray();

        $this->assertEquals(["Example Studio\nemail: photos@example.com"], $xmp->getCopyrights());
        $this->assertEquals($xmp->getCopyrights(), $xmpArray['copyrights']);

        $this->assertEquals(['sample', 'test image', 'gradient', 'shapes', 'Portrait', 'Circle', 'Square'], $xmp->getKeywords());
        $this->assertEquals($xmp->getKeywords(), $xmpArray['keywords']);

        $this->assertEquals(new \DateTime('2017-11-12 18:37:12', new \DateTimeZone('Europe/Rome')), $xmp->getCreationDateTime());
        $this->assertEquals($xmp->getCreationDateTime(), $xmpArray['created_at']);

        $this->assertEquals(null, $xmp->getCreator());
        $this->assertEquals($xmp->getCreator(), $xmpArray['created_by']);

        $this->assertEquals('writer@example.com', $xmp->getCaptionWriter());
        $this->assertEquals($xmp->getCaptionWriter(), $xmpArray['caption']);

        $this->assertEquals([
            'prefs' => '0:0:0:001234',
            'pm_version' => 'PM5',
            'tagged' => false,
            'color_class' => 0,
        ], $xmp->getPhotoMechanic());
        $this->assertEquals($xmp->getPhotoMechanic(), $xmpArray['photomechanic']);

        $this->assertEquals('Test City, Example Region.
Sunday 12 November 2017.
A yellow circle and a green square on a gradient background.
ref: Synthetic Image 001234', $xmp->getDescription());
        $this->assertEquals($xmp->getDescription(), $xmpArray['description']);

        $this->assertFalse($xmp->isEmpty());
    }
}
