<?php

namespace Jackal\ImageMerge\Test\FunctionalTest;

use Jackal\ImageMerge\ImageMerge;
use Jackal\ImageMerge\Model\Image;

class SaveImageTest extends ImageTestCase
{
    public function testWebPImage(): void
    {
        if (!function_exists('imagewebp')) {
            $this->markTestSkipped('imagewebp not supported');
        }

        $builder = ImageMerge::fromPath(__DIR__ . '/Resources/ImageTest/03.jpg');

        $this->assertWebPSameImage($builder->getImage(), __DIR__ . '/Resources/ImageTest/03.webp');
    }

    public function testSaveCreatesNonWorldWritableDirectories(): void
    {
        $directory = sys_get_temp_dir() . '/' . bin2hex(random_bytes(8));
        $pathname = $directory . '/nested/image.png';

        $oldUmask = umask(0);

        try {
            $this->assertTrue((new Image(10, 10))->toPNG($pathname));
        } finally {
            umask($oldUmask);
        }

        $this->assertFileExists($pathname);
        $this->assertSame(0755, fileperms($directory) & 0777);

        unlink($pathname);
        rmdir($directory . '/nested');
        rmdir($directory);
    }

    public function testJpegContentType(): void
    {
        $this->assertSame('image/jpeg', (new Image(10, 10))->toJPG()->headers->get('content-type'));
    }
}
