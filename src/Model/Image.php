<?php

namespace Jackal\ImageMerge\Model;

use Jackal\ImageMerge\Command\BlurCommand;
use Jackal\ImageMerge\Command\BorderCommand;
use Jackal\ImageMerge\Command\CommandInterface;
use Jackal\ImageMerge\Command\CropCenterCommand;
use Jackal\ImageMerge\Command\CropCommand;
use Jackal\ImageMerge\Command\GrayScaleCommand;
use Jackal\ImageMerge\Command\Options\BorderCommandOption;
use Jackal\ImageMerge\Command\Options\CommandOptionInterface;
use Jackal\ImageMerge\Command\Options\CropCommandOption;
use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use Jackal\ImageMerge\Command\Options\SingleCoordinateFileObjectCommandOption;
use Jackal\ImageMerge\Command\PixelCommand;
use Jackal\ImageMerge\Command\ResizeCommand;
use Jackal\ImageMerge\Command\RotateCommand;
use Jackal\ImageMerge\Command\Asset\ImageAsset;
use Jackal\ImageMerge\Command\ThumbnailCommand;
use Jackal\ImageMerge\Factory\CommandFactory;
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

    /**
     * @param $className
     * @param CommandOptionInterface $options
     * @return Image
     */
    protected function addCommand($className, CommandOptionInterface $options = null)
    {
        $command = CommandFactory::getInstance($className, $this, $options);
        return $this->add($command);
    }

    /**
     * @param \SplFileObject $filePathName
     * @return Image
     */
    public static function fromFile(\SplFileObject $filePathName)
    {
        $resource = ImageReader::fromPathname($filePathName);
        $imageResource = $resource->getResource();

        $image = new self(imagesx($imageResource), imagesy($imageResource));
        $image->add(new ImageAsset($image, new SingleCoordinateFileObjectCommandOption($filePathName, 0, 0)));
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
     * @param CommandInterface $command
     * @return Image
     */
    public function add(CommandInterface $command)
    {
        return $command->execute();
    }

    /**
     * @param $level
     * @return Image
     */
    public function blur($level)
    {
        return $this->addCommand(BlurCommand::class, new LevelCommandOption($level));
    }

    /**
     * @param $width
     * @param $height
     * @return Image
     */
    public function resize($width, $height)
    {
        return $this->addCommand(ResizeCommand::class, new DimensionCommandOption($width, $height));
    }

    /**
     * @param $degree
     * @return Image
     */
    public function rotate($degree)
    {
        return $this->addCommand(RotateCommand::class, new LevelCommandOption($degree));
    }

    /**
     * @param $level
     * @return Image
     */
    public function pixelate($level)
    {
        return $this->addCommand(PixelCommand::class, new LevelCommandOption($level));
    }

    /**
     * @param $stroke
     * @param string $colorHex
     * @return Image
     */
    public function border($stroke, $colorHex = 'FFFFFF')
    {
        return $this->addCommand(BorderCommand::class, new BorderCommandOption($stroke, $colorHex));
    }

    /**
     * @param $width
     * @param $height
     * @return Image
     */
    public function cropCenter($width, $height)
    {
        return $this->addCommand(CropCenterCommand::class, new DimensionCommandOption($width, $height));
    }

    public function crop($x, $y, $width, $height)
    {
        return $this->addCommand(CropCommand::class, new CropCommandOption($x, $y, $width, $height));
    }

    public function thumbnail($width = null, $height = null)
    {
        return $this->addCommand(ThumbnailCommand::class, new DimensionCommandOption($width, $height));
    }

    public function grayScale()
    {
        return $this->addCommand(GrayScaleCommand::class, null);
    }

    /**
     * @return resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param null $filePathName
     * @return bool|string
     */
    public function toPNG($filePathName = null)
    {
        return ImageWriter::toPNG($this->getResource(), $filePathName);
    }

    /**
     * @param null $filePathName
     * @return bool|string
     */
    public function toJPG($filePathName = null)
    {
        return ImageWriter::toJPG($this->getResource(), $filePathName);
    }

    /**
     * @param null $filePathName
     * @return bool|string
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

    public function getAspectRatio()
    {
        return $this->getWidth() / $this->getHeight();
    }
}
