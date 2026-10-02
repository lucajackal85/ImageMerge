<?php

namespace Jackal\ImageMerge\Test\FunctionalTest;

use InvalidArgumentException;
use Jackal\ImageMerge\Command\Effect\EffectBlurCentered;
use Jackal\ImageMerge\Command\Effect\ScannedDocument;
use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use Jackal\ImageMerge\Command\ResizeCommand;
use Jackal\ImageMerge\ImageMerge;
use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Model\File\FileTempObject;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\ValueObject\Dimention;
use PHPUnit\Framework\TestCase;

class RegressionTest extends TestCase
{
    private const SOURCE = __DIR__ . '/Resources/ImageTest/03.jpg'; // 620x350

    public function testThumbnailWithOnlyWidth(): void
    {
        $image = ImageMerge::fromPath(self::SOURCE)->thumbnail(200, null)->getImage();

        $this->assertSame([200, 113], [$image->getWidth(), $image->getHeight()]);
    }

    public function testThumbnailWithOnlyHeight(): void
    {
        $image = ImageMerge::fromPath(self::SOURCE)->thumbnail(null, 100)->getImage();

        $this->assertSame([177, 100], [$image->getWidth(), $image->getHeight()]);
    }

    public function testEffectBlurCentered(): void
    {
        $builder = ImageMerge::fromPath(self::SOURCE);
        $builder->addCommand(new EffectBlurCentered(new DimensionCommandOption(new Dimention(300, 300))));

        $this->assertSame([300, 300], [$builder->getImage()->getWidth(), $builder->getImage()->getHeight()]);
    }

    public function testIsDarkOnRegion(): void
    {
        $image = new Image(100, 100, false);
        ImageMerge::fromImage($image)->addSquare(50, 0, 99, 99, Color::WHITE);

        $this->assertTrue($image->isDark(0, 0, 50, 100));
        $this->assertFalse($image->isDark(50, 0, 50, 100));
        $this->assertSame([100, 100], [$image->getWidth(), $image->getHeight()], 'isDark() must not alter the image');
    }

    public function testCloneDoesNotShareTheGdImage(): void
    {
        $image = new Image(10, 10, false);
        $clone = clone $image;

        ImageMerge::fromImage($clone)->addSquare(0, 0, 9, 9, Color::WHITE);

        $this->assertTrue($image->isDark());
        $this->assertFalse($clone->isDark());
    }

    public function testResourceCloneAfterResize(): void
    {
        $image = ImageMerge::fromPath(self::SOURCE)->resize(100, 50)->getImage();
        $clone = $image->getResourceClone();

        $this->assertSame([100, 50], [imagesx($clone), imagesy($clone)]);
    }

    public function testScannedDocumentWithCustomContrast(): void
    {
        $builder = ImageMerge::fromPath(self::SOURCE);
        $builder->addCommand(new ScannedDocument(new LevelCommandOption(-30)));

        $this->assertTrue($builder->getImage()->isVertical());
    }

    public function testCropOutsideTheImageIsRejected(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ImageMerge::fromImage(new Image(100, 100))->crop(50, 50, 100, 100);
    }

    public function testCropWithNegativeCoordinatesIsRejected(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ImageMerge::fromImage(new Image(100, 100))->crop(-10, 0, 50, 50);
    }

    public function testRotateByLessThanOneDegree(): void
    {
        $image = ImageMerge::fromImage(new Image(100, 50))->rotate(0.5)->getImage();

        $this->assertNotSame([100, 50], [$image->getWidth(), $image->getHeight()]);
    }

    public function testResizeCommandCanBeReused(): void
    {
        $command = new ResizeCommand(new DimensionCommandOption(new Dimention(50, null)));

        $square = $command->execute(new Image(100, 100));
        $landscape = $command->execute(new Image(100, 50));

        $this->assertSame([50, 50], [$square->getWidth(), $square->getHeight()]);
        $this->assertSame([50, 25], [$landscape->getWidth(), $landscape->getHeight()]);
    }

    public function testEmptyFileContents(): void
    {
        $file = FileTempObject::fromString('');

        $this->assertSame('', $file->getContents());
    }

    public function testMergeDoesNotDecodeTheSourceRepeatedly(): void
    {
        // smoke test for ImageAssetCommand: merging must still position the overlay correctly
        $base = new Image(20, 20, false);
        $overlay = new Image(10, 10, false);
        ImageMerge::fromImage($overlay)->addSquare(0, 0, 9, 9, Color::WHITE);

        ImageMerge::fromImage($base)->merge($overlay, 10, 10);

        $this->assertSame(0xFFFFFF, imagecolorat($base->getResource(), 15, 15) & 0xFFFFFF);
        $this->assertSame(0x000000, imagecolorat($base->getResource(), 5, 5) & 0xFFFFFF);
    }

    public function testMetadataWithoutXmpDate(): void
    {
        $builder = ImageMerge::fromPath(__DIR__ . '/Resources/FlipTest/01.png');

        $this->assertNull($builder->getImage()->getMetadata()->getXMP()->getCreationDateTime());
    }

    public function testFileObjectFromPath(): void
    {
        $this->assertNotSame('', (new FileObject(self::SOURCE))->getContents());
    }
}
