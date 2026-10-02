<?php

namespace Jackal\ImageMerge\Test\UnitTest\Model;

use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\Model\Font\Font;
use Jackal\ImageMerge\Model\Text\Text;
use PHPUnit\Framework\TestCase;

class TextTest extends TestCase
{
    public function testTextObject(): void
    {
        $text = new Text('this is a text', Font::liberationSans(), 12, new Color('ABCDEF'));

        $this->assertEquals('this is a text', $text->getText());
        $this->assertEquals(Font::liberationSans(), $text->getFont());
        $this->assertEquals(12, $text->getFontSize());
        $this->assertEquals('ABCDEF', $text->getColor()->getHex());
    }

    public function testDeprecatedArialAliasUsesLiberationSans(): void
    {
        $this->assertEquals(Font::liberationSans(), Font::arial());
    }

    public function testBundledFontShipsWithItsLicense(): void
    {
        $font = (string) Font::liberationSans();

        $this->assertFileExists($font);
        $this->assertStringContainsString(
            'SIL OPEN FONT LICENSE Version 1.1',
            file_get_contents(dirname($font) . '/LICENSE-LiberationSans.txt')
        );
    }

    public function testLiberationSansKeepsArialMetrics(): void
    {
        // Arial at 12pt gives a 64px wide box for this string; Liberation Sans must match
        $text = new Text('this is a text', Font::liberationSans(), 12, new Color('000000'));

        $this->assertEqualsWithDelta(64, $text->getWidth(), 1);
    }
}
