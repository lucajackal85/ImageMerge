<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 25/11/17
 * Time: 10:52
 */

namespace Jackal\ImageMerge\Test\FunctionalTest\Metadata\Parser;


use Jackal\ImageMerge\Metadata\Parser\IPTCParser;
use Jackal\ImageMerge\Model\File\File;
use PHPUnit\Framework\TestCase;

class IPTCParserTest extends TestCase
{
    public function testParseMetadata(){

        $iptc = new IPTCParser(new File(__DIR__.'/../../Resources/0.jpg'));

        $this->assertEquals('andrewhone@gmail.com',$iptc->getCreator());
        $this->assertEquals(new \DateTime('2017-11-12T18:37:12+01:00'),$iptc->getCreationDateTime());

        $this->assertEquals(
            ['f1', 'formula 1', 'formula one', 'gp', 'Portrait', 'Helmets', 'Finish'],
            $iptc->getKeywords()
        );

        $this->assertEquals(
            "LAT Images\nemail: sales@latimages.com",
            $iptc->getCopyrights()
        );

        $this->assertEquals('Interlagos, Sao Paulo, Brazil.
Sunday 12 November 2017.
Sebastian Vettel, Ferrari SF70H, 1st Position, arrives in Parc Ferme.
World Copyright: Andy Hone/LAT Images 
ref: Digital Image _ONY9367',$iptc->getDescription());

        $this->assertTrue($iptc->isUTF8());
        $this->assertFalse($iptc->isEmpty());

        }
}