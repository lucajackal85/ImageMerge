<?php

namespace Jackal\ImageMerge\Model;

use Exception;
use Jackal\ImageMerge\Builder\ImageBuilder;


use Jackal\ImageMerge\Command\Options\SingleCoordinateFileObjectCommandOption;
use Jackal\ImageMerge\Command\Asset\ImageAssetCommand;
use Jackal\ImageMerge\Exception\InvalidColorException;
use Jackal\ImageMerge\Http\Response\ImageResponse;
use Jackal\ImageMerge\Metadata\Metadata;
use Jackal\ImageMerge\Model\File\FileObjectInterface;
use Jackal\ImageMerge\Model\File\FileTempObject;
use Jackal\ImageMerge\Model\Format\ImageReader;
use Jackal\ImageMerge\Model\Format\ImageWriter;
use Jackal\ImageMerge\Utils\ColorUtils;
use Jackal\ImageMerge\ValueObject\Coordinate;

/**
 * Class Image
 * @package Jackal\ImageMerge\Model
 */
class Image
{
    /**
     * @var integer
     */
    private $width;

    /**
     * @var integer
     */
    private $height;

    /**
     * @var resource
     */
    private $resource;

    /**
     * @var Metadata
     */
    private $metadata;

    /**
     * Image constructor.
     * @param $width
     * @param $height
     * @param bool $transparent
     * @throws InvalidColorException
     */
    public function __construct($width, $height, $transparent = true)
    {
        $this->width = $width;
        $this->height = $height;

        $resource = imagecreatetruecolor($this->width, $this->height);
        imagecolortransparent($resource);

        if ($transparent) {
            imagesavealpha($resource, true);
            $color = ColorUtils::colorIdentifier($resource, new Color(Color::BLACK), true);
            imagefill($resource, 0, 0, $color);
        }

        $this->resource= $resource;
    }

    /**
     * @param FileObjectInterface $filePathName
     * @return Image
     * @throws Exception
     */
    public static function fromFile(FileObjectInterface $filePathName)
    {
        $resource = ImageReader::fromPathname($filePathName);
        $imageResource = $resource->getResource();

        $image = new self(imagesx($imageResource), imagesy($imageResource));
        $command = new ImageAssetCommand(new SingleCoordinateFileObjectCommandOption($filePathName, new Coordinate(0, 0)));
        $command->execute($image);
        return $image;
    }

    /**
     * @param $contentString
     * @return Image
     * @throws Exception
     */
    public static function fromString($contentString)
    {
        $file = FileTempObject::fromString($contentString);
        $resource = ImageReader::fromPathname($file);

        $image = new self(imagesx($resource->getResource()), imagesy($resource->getResource()));
        $command = new ImageAssetCommand(new SingleCoordinateFileObjectCommandOption($file, new Coordinate(0, 0)));
        $command->execute($image);

        return $image;
    }

    /**
     * @param $resource
     * @return Image
     */
    public function assignResource($resource)
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
    public function isDark($fromX = null, $fromY = null, $width =null, $height = null)
    {
        $samples = 10;
        $threshold = 60;

        if (!is_null($fromY) and !is_null($fromY) and !is_null($width) and !is_null($height)) {
            $builder = new ImageBuilder(clone $this);
            $builder->crop($fromX, $fromY, $width, $height);
            $portion = $builder->getImage();
        } else {
            $portion = $this;
        }

        $luminance = 0;
        for ($x=1;$x<=$samples;$x++) {
            for ($y=1;$y<=$samples;$y++) {
                $coordX = round($portion->getWidth() / $samples * $x) - ($portion->getWidth() / $samples / 2);
                $cooordY = round($portion->getHeight() / $samples * $y) - ($portion->getHeight() / $samples / 2);
                $rgb = imagecolorat($portion->getResource(), $coordX, $cooordY);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                // choose a simple luminance formula from here
                // http://stackoverflow.com/questions/596216/formula-to-determine-brightness-of-rgb-color
                $luminance += ($r+$r+$b+$g+$g+$g)/6;
            }
        }
        return $luminance / ($samples * $samples) <= $threshold;
    }

    /**
     * @return resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    public function getResourceClone()
    {
        $original = $this->resource;
        $copy = imagecreatetruecolor($this->width, $this->height);

        imagecopy($copy, $original, 0, 0, 0, 0, $this->width, $this->height);

        return $copy;
    }

    /**
     * @param null $filePathName
     * @return bool|ImageResponse
     * @throws Exception
     */
    public function toPNG($filePathName = null)
    {
        return ImageWriter::toPNG($this->getResource(), $filePathName);
    }

    /**
     * @param null $filePathName
     * @return bool|ImageResponse
     * @throws Exception
     */
    public function toJPG($filePathName = null)
    {
        return ImageWriter::toJPG($this->getResource(), $filePathName);
    }

    /**
     * @param null $filePathName
     * @return bool|ImageResponse
     * @throws Exception
     */
    public function toGIF($filePathName = null)
    {
        return ImageWriter::toGIF($this->getResource(), $filePathName);
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return imagesx($this->getResource());
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return imagesy($this->getResource());
    }

    /**
     * @return float
     */
    public function getAspectRatio()
    {
        return $this->getWidth() / $this->getHeight();
    }

    /**
     * @return bool
     */
    public function isVertical()
    {
        return $this->getAspectRatio() < 1;
    }

    /**
     * @return bool
     */
    public function isHorizontal()
    {
        return $this->getAspectRatio() > 1;
    }

    /**
     * @return bool
     */
    public function isSquare()
    {
        return $this->getAspectRatio() == 1;
    }

    public function addMetadata(Metadata $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }
}
