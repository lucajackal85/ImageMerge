<?php

namespace Jackal\ImageMerge\Model;

use Jackal\ImageMerge\Command\BlurCommand;
use Jackal\ImageMerge\Command\BorderCommand;
use Jackal\ImageMerge\Command\BrightnessCommand;
use Jackal\ImageMerge\Command\CommandInterface;
use Jackal\ImageMerge\Command\CropCenterCommand;
use Jackal\ImageMerge\Command\CropCommand;
use Jackal\ImageMerge\Command\CropPolygonCommand;
use Jackal\ImageMerge\Command\GrayScaleCommand;
use Jackal\ImageMerge\Command\Options\MultiCoordinateCommandOption;
use Jackal\ImageMerge\Command\Options\BorderCommandOption;
use Jackal\ImageMerge\Command\Options\CommandOptionInterface;
use Jackal\ImageMerge\Command\Options\CropCommandOption;
use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use Jackal\ImageMerge\Command\Options\SingleCoordinateCommandOption;
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

    public function brightness($level)
    {
        return $this->addCommand(BrightnessCommand::class, new LevelCommandOption($level));
    }

    /**
     * @param $x
     * @param $y
     * @param $width
     * @param $height
     * @return Image
     */
    public function crop($x, $y, $width, $height)
    {
        return $this->addCommand(CropCommand::class, new CropCommandOption($x, $y, $width, $height));
    }

    /**
     * @param $x1
     * @param $y1
     * @param $x2
     * @param $y2
     * @param $x3
     * @param $y3
     * @param array ...$points
     * @return Image
     */
    public function cropPolygon($x1, $y1, $x2, $y2, $x3, $y3, ...$points)
    {
        $points = func_get_args();
        $coords = [];

        foreach ($points as $k => $point) {
            if ($k == 0 or ($k %2) == 0) {
                if (isset($points[$k + 1])) {
                    $x = $point;
                    $y = $points[$k + 1];
                    $coords[] = new SingleCoordinateCommandOption($x, $y);
                }
            }
        }

        return $this->addCommand(CropPolygonCommand::class, new MultiCoordinateCommandOption($coords));
    }

    /**
     * @param null $width
     * @param null $height
     * @return Image
     */
    public function thumbnail($width = null, $height = null)
    {
        return $this->addCommand(ThumbnailCommand::class, new DimensionCommandOption($width, $height));
    }

    /**
     * @return Image
     */
    public function grayScale()
    {
        return $this->addCommand(GrayScaleCommand::class, null);
    }

    /**
     * @param int|null $fromX
     * @param int|null $fromY
     * @param int|null $width
     * @param int|null $height
     * @return bool
     */
    public function isDark($fromX = null, $fromY = null, $width =null, $height = null)
    {
        $samples = 10;
        $threshold = 60;

        if (!is_null($fromY) and !is_null($fromY) and !is_null($width) and !is_null($height)) {
            $portion = clone $this;
            $portion->crop($fromX, $fromY, $width, $height);
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
        return $this->getAspectRatio() < 0;
    }

    /**
     * @return bool
     */
    public function isHorizontal()
    {
        return $this->getAspectRatio() > 0;
    }

    /**
     * @return bool
     */
    public function isSquare()
    {
        return $this->getAspectRatio() == 0;
    }
}
