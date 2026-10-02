<?php

namespace Jackal\ImageMerge;

use InvalidArgumentException;
use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Loader\UrlLoader;
use Jackal\ImageMerge\Metadata\Metadata;
use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Model\File\FileTempObject;
use Jackal\ImageMerge\Model\Image;
use SplFileObject;

/**
 * Entry point: create an ImageBuilder from an explicit source type.
 */
final class ImageMerge
{
    private function __construct()
    {
    }

    /**
     * Load a local file. Stream wrappers (phar://, php://, http://...) are rejected.
     */
    public static function fromPath(string $path): ImageBuilder
    {
        if (str_contains($path, '://')) {
            throw new InvalidArgumentException(sprintf('"%s" is not a local path, use fromUrl() for remote files', $path));
        }

        if (!is_file($path)) {
            throw new InvalidArgumentException(sprintf('File "%s" not found', $path));
        }

        return self::fromFileObject(new FileObject($path));
    }

    /**
     * Load an image from its binary content.
     */
    public static function fromContent(string $content): ImageBuilder
    {
        Limits::default()->assertFileSize(strlen($content));

        return self::fromFileObject(FileTempObject::fromString($content));
    }

    /**
     * Download an image over http(s). Private and reserved addresses are refused
     * unless a UrlLoader configured otherwise is passed.
     */
    public static function fromUrl(string $url, ?UrlLoader $loader = null): ImageBuilder
    {
        $loader ??= new UrlLoader();

        return self::fromContent($loader->load($url));
    }

    public static function fromImage(Image $image): ImageBuilder
    {
        return new ImageBuilder($image);
    }

    public static function fromSplFileObject(SplFileObject $file): ImageBuilder
    {
        return self::fromPath($file->getPathname());
    }

    /**
     * @param resource $stream
     */
    public static function fromStream($stream): ImageBuilder
    {
        if (!is_resource($stream) || get_resource_type($stream) !== 'stream') {
            throw new InvalidArgumentException('A stream resource is required');
        }

        $maxFileSize = Limits::default()->getMaxFileSize();
        $content = stream_get_contents($stream, $maxFileSize + 1);
        if ($content === false) {
            throw new InvalidArgumentException('Unable to read stream');
        }

        return self::fromContent($content);
    }

    private static function fromFileObject(FileObject $file): ImageBuilder
    {
        $image = Image::fromFile($file);
        $image->addMetadata(new Metadata($file));

        return new ImageBuilder($image);
    }
}
