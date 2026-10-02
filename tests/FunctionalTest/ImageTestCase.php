<?php

namespace Jackal\ImageMerge\Test\FunctionalTest;

use Jackal\ImageMerge\Model\Image;
use PHPUnit\Framework\TestCase;

abstract class ImageTestCase extends TestCase
{
    /**
     * Maximum mean per-channel difference (0-255) tolerated between two images,
     * to absorb encoder differences across GD/libjpeg/libwebp versions.
     */
    private const TOLERANCE = 3.0;

    protected function assertPNGSameImage(Image $image, string $expectedPathname): void
    {
        $this->assertSameImage($image->toPNG()->getContent(), $expectedPathname);
    }

    protected function assertJPGSameImage(Image $image, string $expectedPathname): void
    {
        $this->assertSameImage($image->toJPG()->getContent(), $expectedPathname);
    }

    protected function assertWebPSameImage(Image $image, string $expectedPathname): void
    {
        $this->assertSameImage($image->toWebP()->getContent(), $expectedPathname);
    }

    private function assertSameImage(string $actualContent, string $expectedPathname): void
    {
        $expected = imagecreatefromstring(file_get_contents($expectedPathname));
        $actual = imagecreatefromstring($actualContent);

        $this->assertSame(
            [imagesx($expected), imagesy($expected)],
            [imagesx($actual), imagesy($actual)],
            'Image dimensions differ'
        );

        $width = imagesx($expected);
        $height = imagesy($expected);
        $diff = 0;

        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $e = imagecolorsforindex($expected, imagecolorat($expected, $x, $y));
                $a = imagecolorsforindex($actual, imagecolorat($actual, $x, $y));
                $diff += abs($e['red'] - $a['red']) + abs($e['green'] - $a['green']) + abs($e['blue'] - $a['blue']);
            }
        }

        $mean = $diff / ($width * $height * 3);

        $this->assertLessThanOrEqual(self::TOLERANCE, $mean, sprintf('Images differ (mean channel difference %.2f)', $mean));
    }
}
