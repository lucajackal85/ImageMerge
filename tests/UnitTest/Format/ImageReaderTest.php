<?php

namespace Jackal\ImageMerge\Test\UnitTest\Format;

use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Model\Format\ImageReader;
use PHPUnit\Framework\TestCase;

class ImageReaderTest extends TestCase
{
    public function testReadJPG(): void
    {

        $ir = ImageReader::fromPathname(new FileObject(__DIR__ . '/../../Fixtures/photo-with-metadata.jpg'));

        $this->assertEquals(ImageReader::FORMAT_JPG, $ir->getFormat());
    }

    public function testReadPNG(): void
    {

        $ir = ImageReader::fromPathname(new FileObject(__DIR__ . '/../Resources/ImageReaderTest/02.png'));

        $this->assertEquals(ImageReader::FORMAT_PNG, $ir->getFormat());
    }

    public function testReadGIF(): void
    {

        $ir = ImageReader::fromPathname(new FileObject(__DIR__ . '/../Resources/ImageReaderTest/03.gif'));

        $this->assertEquals(ImageReader::FORMAT_GIF, $ir->getFormat());
    }

    public function testReadWEBP(): void
    {

        $ir = ImageReader::fromPathname(new FileObject(__DIR__ . '/../Resources/ImageReaderTest/04.webp'));

        $this->assertEquals(ImageReader::FORMAT_WEBP, $ir->getFormat());
    }

    public function testRaiseExceptionOnUndecodableImage(): void
    {
        // animated WebP: valid header, but GD cannot decode it
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unable to decode image');

        ImageReader::fromPathname(new FileObject(__DIR__ . '/../Resources/ImageReaderTest/05-animated.webp'));
    }

    public function testRaiseExceptionOnInvalidFile(): void
    {

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('File is not a valid image type [extension: "php"]');
        ImageReader::fromPathname(new FileObject(__FILE__));
    }
}
