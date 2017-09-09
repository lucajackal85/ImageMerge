<?php

namespace Jackal\ImageMerge\Model;

use Jackal\ImageMerge\Command\AssetCommand;
use Jackal\ImageMerge\Command\BlurCommand;
use Jackal\ImageMerge\Command\ResizeCommand;
use Jackal\ImageMerge\Command\RotateCommand;
use Jackal\ImageMerge\Effect\EffectInterface;
use Jackal\ImageMerge\Exception\UnsupportedConfigurationException;
use Jackal\ImageMerge\Generator\ImageGenerator;
use Jackal\ImageMerge\Model\Asset\AssetInterface;
use Jackal\ImageMerge\Model\Asset\ImageAsset;
use Jackal\ImageMerge\Model\Configuration\ImageConfiguration;
use Jackal\ImageMerge\Model\Format\ImageFormat;
use Jackal\ImageMerge\Model\Format\ImageReader;
use Jackal\ImageMerge\Model\Format\ImageWriter;

class Image
{
    private $width;

    private $height;

    private $resource;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;

        $resource = imagecreatetruecolor($this->width, $this->height);
        imagecolortransparent($resource);

        $this->resource= $resource;
    }

    public static function fromFile(\SplFileObject $filePathName)
    {
        $resource = ImageReader::fromPathname($filePathName);
        $imageResource = $resource->getResource();

        $image = new self(imagesx($imageResource), imagesy($imageResource));
        $image->addAsset(new ImageAsset($filePathName, 0, 0));
        return $image;
    }

    public function blur($level)
    {
        $cmd = new BlurCommand($this, $level);
        return $cmd->execute();
    }

    public function resize($width, $height)
    {
        $cmd = new ResizeCommand($this, $width, $height);
        return $cmd->execute();
    }

    public function assignResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }

    public function addAsset(AssetInterface $asset)
    {
        $cmd = new AssetCommand($this, $asset);
        return $cmd->execute();
    }

    public function rotate($degree)
    {
        $cmd = new RotateCommand($this, $degree);
        return $cmd->execute();
    }

    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param null $filePathName
     * @return bool|int|string
     */
    public function toPNG($filePathName= null)
    {
        $output = ImageWriter::toPNG($this->getResource());
        if ($filePathName) {
            return file_put_contents($filePathName, $output);
        }
        return $output;
    }

    /**
     * @param null $filePathName
     * @return bool|int|string
     */
    public function toJPG($filePathName= null)
    {
        $output = ImageWriter::toJPG($this->getResource());
        if ($filePathName) {
            return file_put_contents($filePathName, $output);
        }
        return $output;
    }

    /**
     * @param null $filePathName
     * @return string
     */
    public function toGIF($filePathName= null)
    {
        $output = ImageWriter::toGIF($this->getResource());
        if ($filePathName) {
            file_put_contents($filePathName, $output);
        }
        return $output;
    }

    public function addEffect(EffectInterface $effect)
    {
        return $effect->execute($this);
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
}
