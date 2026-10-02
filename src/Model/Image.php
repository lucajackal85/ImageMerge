<?php

namespace Jackal\ImageMerge\Model;

use Exception;
use GdImage;
use Jackal\ImageMerge\Builder\ImageBuilder;

use Jackal\ImageMerge\Exception\InvalidColorException;
use Jackal\ImageMerge\Http\Response\ImageResponse;
use Jackal\ImageMerge\Limits;
use Jackal\ImageMerge\Metadata\Metadata;
use Jackal\ImageMerge\Model\File\FileObjectInterface;
use Jackal\ImageMerge\Model\File\FileTempObject;
use Jackal\ImageMerge\Model\Format\ImageReader;
use Jackal\ImageMerge\Model\Format\ImageWriter;
use Jackal\ImageMerge\Utils\ColorUtils;

/**
 * Class Image
 * @package Jackal\ImageMerge\Model
 */
class Image
{
    /**
     * @var GdImage
     */
    private GdImage $resource;

    /**
     * @var Metadata
     */
    private ?Metadata $metadata = null;

    /**
     * Image constructor.
     * @param $width
     * @param $height
     * @param bool $transparent
     * @throws InvalidColorException
     */
    public function __construct(int $width, int $height, bool $transparent = true)
    {
        Limits::default()->assertDimensions((int) $width, (int) $height);

        $resource = imagecreatetruecolor($width, $height);
        imagecolortransparent($resource);

        if ($transparent) {
            imagesavealpha($resource, true);
            $color = ColorUtils::colorIdentifier($resource, new Color(Color::BLACK), true);
            imagefill($resource, 0, 0, $color);
        }

        $this->resource = $resource;
    }

    /**
     * @param FileObjectInterface $filePathName
     * @return Image
     * @throws Exception
     */
    public static function fromFile(FileObjectInterface $filePathName): self
    {
        return self::fromDecoded(ImageReader::fromPathname($filePathName)->getResource());
    }

    /**
     * @param $contentString
     * @return Image
     * @throws Exception
     */
    public static function fromString(string $contentString): self
    {
        return self::fromFile(FileTempObject::fromString($contentString));
    }

    /**
     * Copies a decoded image onto a new truecolor canvas with alpha support.
     */
    private static function fromDecoded(GdImage $decoded): self
    {
        $image = new self(imagesx($decoded), imagesy($decoded));
        imagecopyresampled($image->getResource(), $decoded, 0, 0, 0, 0, imagesx($decoded), imagesy($decoded), imagesx($decoded), imagesy($decoded));

        return $image;
    }

    /**
     * @param $resource
     * @return Image
     */
    public function assignResource(GdImage $resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * @param null $fromX
     * @param null $fromY
     * @param null $width
     * @param null $height
     * @return bool
     * @throws Exception
     */
    public function isDark(?int $fromX = null, ?int $fromY = null, ?int $width = null, ?int $height = null): bool
    {
        $samples = 10;
        $threshold = 60;

        if (!is_null($fromX) and !is_null($fromY) and !is_null($width) and !is_null($height)) {
            $builder = new ImageBuilder(clone $this);
            $builder->crop($fromX, $fromY, $width, $height);
            $portion = $builder->getImage();
        } else {
            $portion = $this;
        }

        $luminance = 0;
        for ($x = 1;$x <= $samples;$x++) {
            for ($y = 1;$y <= $samples;$y++) {
                $coordX = min($portion->getWidth() - 1, (int) round($portion->getWidth() / $samples * ($x - 0.5)));
                $coordY = min($portion->getHeight() - 1, (int) round($portion->getHeight() / $samples * ($y - 0.5)));
                $rgb = imagecolorat($portion->getResource(), $coordX, $coordY);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                // choose a simple luminance formula from here
                // http://stackoverflow.com/questions/596216/formula-to-determine-brightness-of-rgb-color
                $luminance += ($r + $r + $b + $g + $g + $g) / 6;
            }
        }

        return $luminance / ($samples * $samples) <= $threshold;
    }

    /**
     * @return GdImage
     */
    public function getResource(): GdImage
    {
        return $this->resource;
    }

    /**
     * @return GdImage a copy of the current image, alpha channel included
     */
    public function getResourceClone(): GdImage
    {
        $copy = imagecreatetruecolor($this->getWidth(), $this->getHeight());
        imagealphablending($copy, false);
        imagesavealpha($copy, true);
        imagecopy($copy, $this->resource, 0, 0, 0, 0, $this->getWidth(), $this->getHeight());

        return $copy;
    }

    /**
     * Clones must not share the underlying GD image, otherwise in-place
     * commands (blur, filters, drawing) would alter both.
     */
    public function __clone()
    {
        $this->resource = $this->getResourceClone();
    }

    /**
     * @param null $filePathName
     * @return bool|ImageResponse
     * @throws Exception
     */
    public function toPNG(?string $filePathName = null): bool|ImageResponse
    {
        return ImageWriter::toPNG($this->getResource(), $filePathName);
    }

    /**
     * @param null $filePathName
     * @return bool|ImageResponse
     * @throws Exception
     */
    public function toJPG(?string $filePathName = null): bool|ImageResponse
    {
        return ImageWriter::toJPG($this->getResource(), $filePathName);
    }

    /**
     * @param null $filePathName
     * @return bool|ImageResponse
     * @throws Exception
     */
    public function toGIF(?string $filePathName = null): bool|ImageResponse
    {
        return ImageWriter::toGIF($this->getResource(), $filePathName);
    }

    /**
     * @param null $filePathName
     * @return bool|ImageResponse
     * @throws Exception
     */
    public function toWebP(?string $filePathName = null): bool|ImageResponse
    {
        return ImageWriter::toWebP($this->getResource(), $filePathName);
    }

    /**
     * @return mixed
     */
    public function getWidth(): int
    {
        return imagesx($this->getResource());
    }

    /**
     * @return mixed
     */
    public function getHeight(): int
    {
        return imagesy($this->getResource());
    }

    /**
     * @return float
     */
    public function getAspectRatio(): float
    {
        return $this->getWidth() / $this->getHeight();
    }

    /**
     * @return bool
     */
    public function isVertical(): bool
    {
        return $this->getAspectRatio() < 1;
    }

    /**
     * @return bool
     */
    public function isHorizontal(): bool
    {
        return $this->getAspectRatio() > 1;
    }

    /**
     * @return bool
     */
    public function isSquare(): bool
    {
        return $this->getAspectRatio() == 1;
    }

    public function addMetadata(Metadata $metadata): void
    {
        $this->metadata = $metadata;
    }

    /**
     * @return Metadata
     */
    public function getMetadata(): ?Metadata
    {
        return $this->metadata;
    }
}
