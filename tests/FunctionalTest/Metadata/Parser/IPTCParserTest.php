<?php

namespace Jackal\ImageMerge\Test\FunctionalTest\Metadata\Parser;

use Jackal\ImageMerge\Metadata\Parser\IPTCParser;
use Jackal\ImageMerge\Model\File\FileObject;
use PHPUnit\Framework\TestCase;

class IPTCParserTest extends TestCase
{
    public function testParseMetadata(): void
    {
        $iptc = new IPTCParser(new FileObject(__DIR__ . '/../../../Fixtures/photo-with-metadata.jpg'));
        $iptcArray = $iptc->toArray();

        $this->assertEquals('writer@example.com', $iptc->getCreator());
        $this->assertEquals($iptc->getCreator(), $iptcArray['created_by']);

        $this->assertEquals(new \DateTime('2017-11-12T18:37:12+01:00'), $iptc->getCreationDateTime());
        $this->assertEquals($iptc->getCreationDateTime(), $iptcArray['created_at']);

        $this->assertEquals(['sample', 'test image', 'gradient', 'shapes', 'Portrait', 'Circle', 'Square'], $iptc->getKeywords());
        $this->assertEquals($iptc->getKeywords(), $iptcArray['keywords']);

        $this->assertEquals("Example Studio\nemail: photos@example.com", $iptc->getCopyrights());
        $this->assertEquals($iptc->getCopyrights(), $iptcArray['copyrights']);

        $this->assertEquals('Test City, Example Region.
Sunday 12 November 2017.
A yellow circle and a green square on a gradient background.
ref: Synthetic Image 001234', $iptc->getDescription());
        $this->assertEquals($iptc->getDescription(), $iptcArray['description']);

        $this->assertTrue($iptc->isUTF8());
        $this->assertTrue($iptcArray['utf8']);

        $this->assertFalse($iptc->isEmpty());
    }
}
