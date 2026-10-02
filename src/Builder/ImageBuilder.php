<?php

namespace Jackal\ImageMerge\Builder;

use Exception;
use InvalidArgumentException;
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
use Jackal\ImageMerge\Command\Options\SingleCoordinateFileObjectCommandOption;
use Jackal\ImageMerge\Command\Options\TextCommandOption;
use Jackal\ImageMerge\Command\PixelCommand;
use Jackal\ImageMerge\Command\ResizeCommand;
use Jackal\ImageMerge\Command\RotateCommand;
use Jackal\ImageMerge\Exception\InvalidColorException;
use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\Model\File\FileTempObject;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\Model\Text\Text;
use Jackal\ImageMerge\ValueObject\Coordinate;
use Jackal\ImageMerge\ValueObject\Dimension;

class ImageBuilder
{
    public function __construct(protected Image $image)
    {
    }

    public function addCommand(CommandInterface $command): self
    {
        $this->image = $command->execute($this->image);

        return $this;
    }

    public function blur(int $level): self
    {
        return $this->addCommand(new BlurCommand(new LevelCommandOption($level)));
    }

    public function resize(?int $width = null, ?int $height = null): self
    {
        return $this->addCommand(new ResizeCommand(new DimensionCommandOption(new Dimension($width, $height))));
    }

    public function rotate(int|float $degree): self
    {
        return $this->addCommand(new RotateCommand(new LevelCommandOption($degree)));
    }

    public function flipVertical(): self
    {
        return $this->addCommand(new FlipVerticalCommand());
    }

    public function flipHorizontal(): self
    {
        return $this->addCommand(new FlipHorizontalCommand());
    }

    public function addText(Text $text, int $x1, int $y1): self
    {
        return $this->addCommand(new TextAssetCommand(new TextCommandOption($text, new Coordinate($x1, $y1))));
    }

    /**
     * @param $x1
     * @param $y1
     * @param $x2
     * @param $y2
     * @throws InvalidColorException
     */
    public function addSquare(int $x1, int $y1, int $x2, int $y2, string $colorHex = Color::BLACK): self
    {
        return $this->addCommand(new SquareAssetCommand(
            new DoubleCoordinateColorCommandOption(
                new Coordinate($x1, $y1),
                new Coordinate($x2, $y2),
                new Color($colorHex)
            )
        ));
    }

    /**
     * @throws Exception
     */
    public function merge(Image $image, int $x = 0, int $y = 0): self
    {
        $fileObject = FileTempObject::fromString($image->toPNG()->getContent());

        return $this->addCommand(
            new ImageAssetCommand(
                new SingleCoordinateFileObjectCommandOption($fileObject, new Coordinate($x, $y))
            )
        );
    }

    public function pixelate(int $level): self
    {
        return $this->addCommand(new PixelCommand(new LevelCommandOption($level)));
    }

    /**
     * @param $stroke
     * @throws InvalidColorException
     */
    public function border(int $stroke, string $colorHex = Color::WHITE): self
    {
        return $this->addCommand(new BorderCommand(new BorderCommandOption($stroke, new Color($colorHex))));
    }

    public function cropCenter(int $newWidth, int $newHeight): self
    {
        $width = $this->image->getWidth();
        $height = $this->image->getHeight();

        $x = (int) round(($width - $newWidth) / 2);
        $y = (int) round(($height - $newHeight) / 2);

        return $this->crop($x, $y, $newWidth, $newHeight);
    }

    public function brightness(int $level): self
    {
        return $this->addCommand(new BrightnessCommand(new LevelCommandOption($level)));
    }

    public function crop(int $x, int $y, int $width, int $height): self
    {
        return $this->addCommand(
            new CropCommand(
                new CropCommandOption(
                    new Coordinate($x, $y),
                    new Dimension($width, $height)
                )
            )
        );
    }

    public function cropPolygon(int $x1, int $y1, int $x2, int $y2, int $x3, int $y3, int ...$morePoints): self
    {
        if (count($morePoints) % 2 !== 0) {
            throw new InvalidArgumentException('cropPolygon() needs x,y pairs');
        }

        $points = array_merge([$x1, $y1, $x2, $y2, $x3, $y3], $morePoints);
        $coords = [];

        foreach (array_chunk($points, 2) as [$x, $y]) {
            $coords[] = new Coordinate($x, $y);
        }

        return $this->addCommand(new CropPolygonCommand(
            new MultiCoordinateCommandOption($coords)
        ));
    }

    public function thumbnail(?int $width = null, ?int $height = null): self
    {
        $dimension = new Dimension($width, $height);

        if (!$dimension->getWidth()) {
            $dimension = new Dimension((int) round($this->image->getAspectRatio() * $dimension->getHeight()), $dimension->getHeight());
        }

        if (!$dimension->getHeight()) {
            $dimension = new Dimension($dimension->getWidth(), (int) round($dimension->getWidth() / $this->image->getAspectRatio()));
        }

        $options = new DimensionCommandOption($dimension);

        $thumbAspect = $options->getDimension()->getWidth() / $options->getDimension()->getHeight();

        if ($this->image->getAspectRatio() >= $thumbAspect) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $newHeight = $options->getDimension()->getHeight();
            $newWidth = (int) round($this->image->getWidth() / ($this->image->getHeight() / $options->getDimension()->getHeight()));
        } else {
            // If the thumbnail is wider than the image
            $newHeight = (int) round($this->image->getHeight() / ($this->image->getWidth() / $options->getDimension()->getWidth()));
            $newWidth = $options->getDimension()->getWidth();
        }

        $this->resize($newWidth, $newHeight);
        $this->cropCenter($options->getDimension()->getWidth(), $options->getDimension()->getHeight());

        return $this;
    }

    public function grayScale(): self
    {
        return $this->addCommand(new GrayScaleCommand());
    }

    public function contrast(int $level): self
    {
        return $this->addCommand(new ContrastCommand(new LevelCommandOption($level)));
    }

    public function getImage(): Image
    {
        return $this->image;
    }
}
