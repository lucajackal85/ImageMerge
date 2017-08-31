<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 31/08/17
 * Time: 14.02
 */

namespace Edimotive\ImageMerge\Test\Model\Configuration;

use Edimotive\ImageMerge\Model\Configuration\Asset\TextAssetConfiguration;
use PHPUnit\Framework\TestCase;

class TextAssetConfigurationTest extends TestCase
{
    public function testConstruct()
    {
        $tac = TextAssetConfiguration::create('font', 12, 'ABCDEF');

        $this->assertEquals('171', $tac->getFontColorRed());
        $this->assertEquals('205', $tac->getFontColorGreen());
        $this->assertEquals('239', $tac->getFontColorBlue());

        $this->assertEquals('font', $tac->getFontFilename());
        $this->assertEquals(12, $tac->getFontSize());
    }
}
