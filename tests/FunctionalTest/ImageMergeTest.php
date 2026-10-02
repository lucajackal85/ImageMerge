<?php

namespace Jackal\ImageMerge\Test\FunctionalTest;

use InvalidArgumentException;
use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\ImageMerge;
use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Model\Image;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SplFileObject;

class ImageMergeTest extends TestCase
{
    private const SOURCE = __DIR__ . '/../Fixtures/photo-with-metadata.jpg';

    public function testItShouldCreateFromPath(): void
    {
        $builder = ImageMerge::fromPath(self::SOURCE);

        $this->assertInstanceOf(ImageBuilder::class, $builder);
        $this->assertNotNull($builder->getImage()->getMetadata());
    }

    public function testItShouldCreateFromSplFileObject(): void
    {
        $this->assertInstanceOf(ImageBuilder::class, ImageMerge::fromSplFileObject(new SplFileObject(self::SOURCE)));
    }

    public function testItShouldCreateFromImage(): void
    {
        $image = Image::fromFile(new FileObject(self::SOURCE));

        $this->assertSame($image, ImageMerge::fromImage($image)->getImage());
    }

    public function testItShouldCreateFromContent(): void
    {
        $builder = ImageMerge::fromContent(file_get_contents(self::SOURCE));

        $this->assertInstanceOf(ImageBuilder::class, $builder);
        $this->assertNotNull($builder->getImage()->getMetadata());
    }

    public function testItShouldCreateFromStream(): void
    {
        $stream = fopen(self::SOURCE, 'rb');

        $this->assertInstanceOf(ImageBuilder::class, ImageMerge::fromStream($stream));
    }

    public function testFromPathRejectsStreamWrappers(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ImageMerge::fromPath('phar://' . self::SOURCE);
    }

    public function testFromPathRejectsMissingFile(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ImageMerge::fromPath(__DIR__ . '/does-not-exist.png');
    }

    public function testFromContentDoesNotReadPaths(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('File is not a valid image type');

        ImageMerge::fromContent(self::SOURCE);
    }

    #[Group('network')]
    public function testItShouldCreateFromUrl(): void
    {
        $this->assertInstanceOf(ImageBuilder::class, ImageMerge::fromUrl('https://www.gstatic.com/webp/gallery3/1.sm.png'));
    }
}
