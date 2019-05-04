<?php

namespace Jackal\ImageMerge\Builder;

use Exception;
use Jackal\ImageMerge\Command\Asset\ImageAssetCommand;
use Jackal\ImageMerge\Command\Asset\SquareAssetCommand;
use Jackal\ImageMerge\Command\Asset\TextAssetCommand;
use Jackal\ImageMerge\Command\BlurCommand;
use Jackal\ImageMerge\Command\BorderCommand;
use Jackal\ImageMerge\Command\BrightnessCommand;
use Jackal\ImageMerge\Command\CommandInterface;
use Jackal\ImageMerge\Command\ContrastCommand;
use Jackal\ImageMerge\Command\CropCommand;
use Jackal\ImageMerge\Command\CropPolygonCommand;
use Jackal\ImageMerge\Command\FlipHorizontalCommand;
use Jackal\ImageMerge\Command\FlipVerticalCommand;
use Jackal\ImageMerge\Command\GrayScaleCommand;
use Jackal\ImageMerge\Command\Options\BorderCommandOption;
use Jackal\ImageMerge\Command\Options\CropCommandOption;
use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Command\Options\DoubleCoordinateColorCommandOption;
use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use Jackal\ImageMerge\Command\Options\MultiCoordinateCommandOption;
use Jackal\ImageMerge\Command\Options\SingleCoordinateCommandOption;
use Jackal\ImageMerge\Command\Options\SingleCoordinateFileObjectCommandOption;
use Jackal\ImageMerge\Command\Options\TextCommandOption;
use Jackal\ImageMerge\Command\PixelCommand;
use Jackal\ImageMerge\Command\ResizeCommand;
use Jackal\ImageMerge\Command\RotateCommand;
use Jackal\ImageMerge\Exception\InvalidColorException;
use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\ValueObject\Coordinate;
use Jackal\ImageMerge\Model\File\FileTempObject;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\Model\Text\Text;
use Jackal\ImageMerge\ValueObject\Dimention;

class ImageBuilder
{
    /**
     * @var Image
     */
    protected $image;

    /**
     * ImageBuilder constructor.
     * @param Image $image
     */
    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    /**
     * @param CommandInterface $command
     * @return $this
     */
    public function addCommand(CommandInterface $command)
    {
        $this->image = $command->execute($this->image);
        return $this;
    }

    /**
     * @param $level
     * @return ImageBuilder
     */
    public function blur($level)
    {
        return $this->addCommand(new BlurCommand(new LevelCommandOption($level)));
    }

    /**
     * @param null $width
     * @param null $height
     * @return ImageBuilder
     */
    public function resize($width = null, $height = null)
    {
        return $this->addCommand(new ResizeCommand(new DimensionCommandOption(new Dimention($width, $height))));
    }

    /**
     * @param $degree
     * @return ImageBuilder
     */
    public function rotate($degree)
    {
        return $this->addCommand(new RotateCommand(new LevelCommandOption($degree)));
    }

    /**
     * @return ImageBuilder
     */
    public function flipVertical()
    {
        return $this->addCommand(new FlipVerticalCommand());
    }

    /**
     * @return ImageBuilder
     */
    public function flipHorizontal()
    {
        return $this->addCommand(new FlipHorizontalCommand());
    }

    /**
     * @param Text $text
     * @param $x1
     * @param $y1
     * @return ImageBuilder
     */
    public function addText(Text $text, $x1, $y1)
    {
        return $this->addCommand(new TextAssetCommand(new TextCommandOption($text, new Coordinate($x1, $y1))));
    }

    /**
     * @param $x1
     * @param $y1
     * @param $x2
     * @param $y2
     * @param string $colorHex
     * @return ImageBuilder
     * @throws InvalidColorException
     */
    public function addSquare($x1, $y1, $x2, $y2, $colorHex = COLOR::BLACK)
    {
        return $this->addCommand(new SquareAssetCommand(
            new DoubleCoordinateColorCommandOption(
                new Coordinate($x1, $y1),
                new Coordinate($x2, $y2),
                new Color($colorHex))
        ));
    }

    /**
     * @param Image $image
     * @param int $x
     * @param int $y
     * @return ImageBuilder
     * @throws Exception
     */
    public function merge(Image $image, $x = 0, $y = 0)
    {
        $fileObject = FileTempObject::fromString($image->toPNG()->getContent());

        return $this->addCommand(
            new ImageAssetCommand(
                new SingleCoordinateFileObjectCommandOption($fileObject, new Coordinate($x, $y))
            )
        );
    }

    /**
     * @param $level
     * @return ImageBuilder
     */
    public function pixelate($level)
    {
        return $this->addCommand(new PixelCommand(new LevelCommandOption($level)));
    }

    /**
     * @param $stroke
     * @param string $colorHex
     * @return ImageBuilder
     * @throws InvalidColorException
     */
    public function border($stroke, $colorHex = Color::WHITE)
    {
        return $this->addCommand(new BorderCommand(new BorderCommandOption($stroke, new Color($colorHex))));
    }

    /**
     * @param $newWidth
     * @param $newHeight
     * @return ImageBuilder
     */
    public function cropCenter($newWidth, $newHeight)
    {
        $width = $this->image->getWidth();
        $height = $this->image->getHeight();

        $x = round(($width- $newWidth) / 2);
        $y = round(($height - $newHeight) / 2);

        return $this->crop($x, $y, $newWidth, $newHeight);
    }

    /**
     * @param $level
     * @return ImageBuilder
     */
    public function brightness($level)
    {
        return $this->addCommand(new BrightnessCommand(new LevelCommandOption($level)));
    }

    /**
     * @param $x
     * @param $y
     * @param $width
     * @param $height
     * @return ImageBuilder
     */
    public function crop($x, $y, $width, $height)
    {
        return $this->addCommand(
            new CropCommand(
                new CropCommandOption(
                    new Coordinate($x, $y),
                    new Dimention($width, $height)
                )
            )
        );
    }

    /**
     * @param $x1
     * @param $y1
     * @param $x2
     * @param $y2
     * @param $x3
     * @param $y3
     * @return ImageBuilder
     */
    public function cropPolygon($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $points = func_get_args();
        $coords = [];

        foreach ($points as $k => $point) {
            if ($k == 0 or ($k %2) == 0) {
                if (isset($points[$k + 1])) {
                    $x = $point;
                    $y = $points[$k + 1];
                    $coords[] = new SingleCoordinateCommandOption(new Coordinate($x, $y));
                }
            }
        }

        return $this->addCommand(new CropPolygonCommand(
            new MultiCoordinateCommandOption($coords)
        ));
    }

    /**
     * @param null $width
     * @param null $height
     * @return $this
     */
    public function thumbnail($width = null, $height = null)
    {
        /** @var DimensionCommandOption $options */
        $options = new DimensionCommandOption(new Dimention($width, $height));

        if (!$options->getDimention()->getWidth()) {
            $options->add('width', round($this->image->getAspectRatio() * $options->getDimention()->getHeight()));
        }

        if (!$options->getDimention()->getHeight()) {
            $options->add('height', round($options->getDimention()->getWidth() / $this->image->getAspectRatio()));
        }

        $thumbAspect = $options->getDimention()->getWidth() / $options->getDimention()->getHeight();

        if ($this->image->getAspectRatio() >= $thumbAspect) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $newHeight = $options->getDimention()->getHeight();
            $newWidth = round($this->image->getWidth() / ($this->image->getHeight() / $options->getDimention()->getHeight()));
        } else {
            // If the thumbnail is wider than the image
            $newHeight = round($this->image->getHeight() / ($this->image->getWidth() / $options->getDimention()->getWidth()));
            $newWidth = $options->getDimention()->getWidth();
        }

        $this->resize($newWidth, $newHeight);
        $this->cropCenter($options->getDimention()->getWidth(), $options->getDimention()->getHeight());

        return $this;
    }


    /**
     * @return ImageBuilder
     */
    public function grayScale()
    {
        return $this->addCommand(new GrayScaleCommand());
    }

    /**
     * @param $level
     * @return ImageBuilder
     */
    public function contrast($level)
    {
        return $this->addCommand(new ContrastCommand(new LevelCommandOption($level)));
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }
}
