<?php

namespace Jackal\ImageMerge\Test\UnitTest;

use Jackal\ImageMerge\Exception\ImageLimitExceededException;
use Jackal\ImageMerge\ImageMerge;
use Jackal\ImageMerge\Limits;
use Jackal\ImageMerge\Model\File\Filename;
use Jackal\ImageMerge\Model\Image;
use PHPUnit\Framework\TestCase;

class LimitsTest extends TestCase
{
    protected function tearDown(): void
    {
        Limits::setDefault(null);
    }

    public function testOversizedImageIsRejectedBeforeDecoding(): void
    {
        // 1x1 PNG whose header is patched to claim 60000x60000 pixels
        $image = imagecreatetruecolor(1, 1);
        ob_start();
        imagepng($image);
        $png = ob_get_clean();
        $png = substr_replace($png, pack('NN', 60000, 60000), 16, 8);

        $this->expectException(ImageLimitExceededException::class);

        ImageMerge::fromContent($png);
    }

    public function testFileSizeLimit(): void
    {
        Limits::setDefault(new Limits(maxFileSize: 10));

        $this->expectException(ImageLimitExceededException::class);

        ImageMerge::fromContent(str_repeat('x', 11));
    }

    public function testCanvasSizeLimit(): void
    {
        Limits::setDefault(new Limits(maxPixels: 100));

        $this->expectException(ImageLimitExceededException::class);

        new Image(20, 20);
    }

    public function testResizeLimit(): void
    {
        Limits::setDefault(new Limits(maxPixels: 10_000));

        $this->expectException(ImageLimitExceededException::class);

        ImageMerge::fromImage(new Image(10, 10))->resize(1000, 1000);
    }

    public function testBlurLimit(): void
    {
        $this->expectException(ImageLimitExceededException::class);

        ImageMerge::fromImage(new Image(10, 10))->blur(1_000_000);
    }

    public function testNegativePixelateLevelIsRejected(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        ImageMerge::fromImage(new Image(10, 10))->pixelate(-1);
    }

    public function testTempFilesArePrivateAndUnpredictable(): void
    {
        $first = Filename::createTempFilename();
        $second = Filename::createTempFilename();

        $this->assertNotSame($first, $second);
        $this->assertFileExists($first);
        $this->assertSame(0600, fileperms($first) & 0777);

        unlink($first);
        unlink($second);
    }
}
