<?php

namespace Jackal\ImageMerge\Model\Format;

use Exception;
use Jackal\ImageMerge\Limits;
use Jackal\ImageMerge\Model\File\FileObjectInterface;

/**
 * Class ImageReader
 * @package Jackal\ImageMerge\Model\Format
 */
final class ImageReader
{
    public const FORMAT_JPG = 'jpg';
    public const FORMAT_PNG = 'png';
    public const FORMAT_GIF = 'gif';
    public const FORMAT_WEBP = 'webp';

    private const FORMATS = [
        IMAGETYPE_PNG => self::FORMAT_PNG,
        IMAGETYPE_JPEG => self::FORMAT_JPG,
        IMAGETYPE_GIF => self::FORMAT_GIF,
        IMAGETYPE_WEBP => self::FORMAT_WEBP,
    ];

    private $resource;

    private $format;

    private function __construct()
    {
    }

    /**
     * Validates type, file size and dimensions from the header *before* decoding,
     * so oversized images are rejected without allocating their pixels.
     *
     * @throws Exception
     */
    public static function fromPathname(FileObjectInterface $filename, ?Limits $limits = null)
    {
        $limits ??= Limits::default();
        $pathname = $filename->getPathname();

        $limits->assertFileSize((int) @filesize($pathname));

        $info = @getimagesize($pathname);
        if ($info === false || !isset(self::FORMATS[$info[2]])) {
            throw new Exception(sprintf(
                'File is not a valid image type [extension: "%s"]',
                strtolower(pathinfo($pathname, PATHINFO_EXTENSION))
            ));
        }

        $limits->assertDimensions($info[0], $info[1]);

        $resource = @imagecreatefromstring($filename->getContents());
        if ($resource === false) {
            throw new Exception(sprintf('Unable to decode image "%s"', $pathname));
        }

        $ir = new self();
        $ir->resource = $resource;
        $ir->format = self::FORMATS[$info[2]];

        return $ir;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return \GdImage
     */
    public function getResource()
    {
        return $this->resource;
    }
}
