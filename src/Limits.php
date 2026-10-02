<?php

namespace Jackal\ImageMerge;

use Jackal\ImageMerge\Exception\ImageLimitExceededException;

/**
 * Resource limits applied when decoding and processing images,
 * to protect against decompression bombs and runaway operations.
 */
final class Limits
{
    private static ?Limits $default = null;

    public function __construct(
        private readonly int $maxPixels = 50_000_000,
        private readonly int $maxFileSize = 50 * 1024 * 1024,
        private readonly int $maxBlurLevel = 100,
    ) {
    }

    public static function default(): self
    {
        return self::$default ??= new self();
    }

    public static function setDefault(?Limits $limits): void
    {
        self::$default = $limits;
    }

    public function getMaxPixels(): int
    {
        return $this->maxPixels;
    }

    public function getMaxFileSize(): int
    {
        return $this->maxFileSize;
    }

    public function getMaxBlurLevel(): int
    {
        return $this->maxBlurLevel;
    }

    public function assertDimensions(int $width, int $height): void
    {
        if ($width < 1 || $height < 1) {
            throw new ImageLimitExceededException(sprintf('Invalid image dimensions %dx%d', $width, $height));
        }

        if ($width * $height > $this->maxPixels) {
            throw new ImageLimitExceededException(sprintf(
                'Image dimensions %dx%d exceed the limit of %d pixels',
                $width,
                $height,
                $this->maxPixels
            ));
        }
    }

    public function assertFileSize(int $bytes): void
    {
        if ($bytes > $this->maxFileSize) {
            throw new ImageLimitExceededException(sprintf(
                'Image size of %d bytes exceeds the limit of %d bytes',
                $bytes,
                $this->maxFileSize
            ));
        }
    }

    public function assertBlurLevel(int $level): void
    {
        if ($level > $this->maxBlurLevel) {
            throw new ImageLimitExceededException(sprintf(
                'Blur level %d exceeds the limit of %d',
                $level,
                $this->maxBlurLevel
            ));
        }
    }
}
