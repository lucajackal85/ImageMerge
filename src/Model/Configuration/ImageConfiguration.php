<?php

namespace Jackal\ImageMerge\Model\Configuration;

use Jackal\ImageMerge\Exception\InvalidFormatException;
use Jackal\ImageMerge\Model\Asset\AssetInterface;
use Jackal\ImageMerge\Model\Format\ImageFormat;
use Jackal\ImageMerge\Model\Format\ImageReader;

class ImageConfiguration
{
    /**
     * @var integer
     */
    protected $width;

    /**
     * @var integer
     */
    protected $height;

    /**
     * @var integer
     */
    protected $outputWidth;

    /**
     * @var integer
     */
    protected $outputHeight;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var AssetInterface[]
     */
    protected $assets = [];

    /**
     * @var \SplFileObject|null
     */
    protected $imagePathname;

    /**
     * ImageConfiguration constructor.
     * @param $width
     * @param $height
     * @param $format
     * @throws InvalidFormatException
     */
    public function __construct($width, $height, $format = ImageFormat::PNG)
    {
        $this->width = $width;
        $this->height = $height;

        $this->outputHeight = $height;
        $this->outputWidth = $width;

        $this->format = $format;
        $this->imagePathname = null;

        if (!in_array($format, ImageFormat::getFormats())) {
            throw new InvalidFormatException($format);
        }
    }

    /**
     * @param \SplFileObject $pathname
     * @return ImageConfiguration
     * @throws InvalidFormatException
     */
    public static function fromFile(\SplFileObject $pathname)
    {
        $resource = ImageReader::fromPathname($pathname);

        $imageConfiguration = new self(imagesx(imagecreatefromjpeg($pathname->getPathname())), imagesy(imagecreatefromjpeg($pathname->getPathname())), $resource->getFormat());
        $imageConfiguration->imagePathname = $pathname;

        if (!in_array($imageConfiguration->format, ImageFormat::getFormats())) {
            throw new InvalidFormatException($imageConfiguration->format);
        }

        return $imageConfiguration;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    public function changeFormat($format)
    {
        return $this->format = $format;
    }

    public function changeOutputDimension($newWidth, $newHeigth)
    {
        $this->outputWidth = $newWidth;
        $this->outputHeight = $newHeigth;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param AssetInterface $asset
     */
    public function addAsset(AssetInterface $asset)
    {
        $this->assets[] = $asset;
    }

    /**
     * @return AssetInterface[]
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * @return null
     */
    public function getBackground()
    {
        return $this->imagePathname;
    }

    /**
     * @return int
     */
    public function getOutputWidth()
    {
        return $this->outputWidth;
    }

    /**
     * @return int
     */
    public function getOutputHeight()
    {
        return $this->outputHeight;
    }
}
