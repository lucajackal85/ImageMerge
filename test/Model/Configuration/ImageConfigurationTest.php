<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 31/08/17
 * Time: 14.11
 */

namespace Jackal\ImageMerge\Test\Model\Configuration;

use Jackal\ImageMerge\Exception\InvalidFormatException;
use Jackal\ImageMerge\Model\Configuration\ImageConfiguration;
use Jackal\ImageMerge\Model\Format\ImageFormat;
use PHPUnit\Framework\TestCase;

class ImageConfigurationTest extends TestCase
{
    public function getValidFormats()
    {
        return [
            [ImageFormat::JPG],
            [ImageFormat::PNG],
            [ImageFormat::GIF],
        ];
    }

    /**
     * @dataProvider getValidFormats()
     */
    public function testConstruct($expectedformat)
    {
        $ic = new ImageConfiguration(800, 600, $expectedformat);

        $this->assertEquals(800, $ic->getWidth());
        $this->assertEquals(600, $ic->getHeight());

        $this->assertEquals(800, $ic->getOutputWidth());
        $this->assertEquals(600, $ic->getOutputHeight());

        $this->assertEquals($expectedformat, $ic->getFormat());

        $this->assertNull($ic->getBackground());
    }

    public function testConstructWithDefaults()
    {
        $ic = new ImageConfiguration(800, 600);
        $this->assertEquals(ImageFormat::PNG, $ic->getFormat());
    }

    public function testItRaiseErrorOnInvalidFormat()
    {
        $this->expectException(InvalidFormatException::class);
        new ImageConfiguration(800, 600, 'invalid');
    }

    public function testChangeFormat()
    {
        $ic = new ImageConfiguration(800, 600);
        $ic->changeFormat(ImageFormat::GIF);

        $this->assertEquals(ImageFormat::GIF, $ic->getFormat());
    }

    public function testChangeOutputDimension()
    {
        $ic = new ImageConfiguration(800, 600);
        $ic->changeOutputDimension(400, 500);


        $this->assertEquals(800, $ic->getWidth());
        $this->assertEquals(600, $ic->getHeight());
        $this->assertEquals(400, $ic->getOutputWidth());
        $this->assertEquals(500, $ic->getOutputHeight());
    }
}
