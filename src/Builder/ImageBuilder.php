<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 08/11/17
 * Time: 15.30
 */

namespace Jackal\ImageMerge\Builder;

use Jackal\ImageMerge\Command\Asset\ImageAssetCommand;
use Jackal\ImageMerge\Command\Asset\SquareAssetCommand;
use Jackal\ImageMerge\Command\Asset\TextAssetCommand;
use Jackal\ImageMerge\Command\BlurCommand;
use Jackal\ImageMerge\Command\BorderCommand;
use Jackal\ImageMerge\Command\BrightnessCommand;
use Jackal\ImageMerge\Command\CropCommand;
use Jackal\ImageMerge\Command\CropPolygonCommand;
use Jackal\ImageMerge\Command\GrayScaleCommand;
use Jackal\ImageMerge\Command\Options\BorderCommandOption;
use Jackal\ImageMerge\Command\Options\CommandOptionInterface;
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
use Jackal\ImageMerge\Factory\CommandFactory;
use Jackal\ImageMerge\Metadata\Metadata;
use Jackal\ImageMerge\Model\Coordinate;
use Jackal\ImageMerge\Model\File\File;
use Jackal\ImageMerge\Model\File\FileTemp;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\Model\Text\Text;

class ImageBuilder
{
    /**
     * @var Image
     */
    protected $image;

    private function __construct()
    {
    }


    /**
     * @param Image $image
     * @return ImageBuilder
     */
    public static function fromImage(Image $image){
        $b = new self();
        $b->image = $image;

        return $b;
    }

    /**
     * @param File $file
     * @return ImageBuilder
     */
    public static function fromFile(File $file){

        $b = new self();
        $b->image = Image::fromFile($file);
        $b->image->addMetadata(new Metadata($file));

        return $b;
    }

    /**
     * @param $contentString
     * @return ImageBuilder
     */
    public static function fromString($contentString){

        $b = new self();
        $b->image = Image::fromString($contentString);
        $b->image->addMetadata(new Metadata(FileTemp::fromString($contentString)));

        return $b;
    }

    /**
     * @param $className
     * @param CommandOptionInterface $options
     * @return ImageBuilder
     */
    public function addCommand($className, CommandOptionInterface $options = null)
    {
        $command = CommandFactory::getInstance($className, $this->image, $options);
        $this->image = $command->execute();
        return $this;
    }

    /**
     * @param $level
     * @return ImageBuilder
     */
    public function blur($level)
    {
        return $this->addCommand(BlurCommand::class, new LevelCommandOption($level));
    }

    /**
     * @param $width
     * @param $height
     * @return ImageBuilder
     */
    public function resize($width, $height)
    {
        return $this->addCommand(ResizeCommand::class, new DimensionCommandOption($width, $height));
    }

    /**
     * @param $degree
     * @return ImageBuilder
     */
    public function rotate($degree)
    {
        return $this->addCommand(RotateCommand::class,
            new LevelCommandOption($degree)
        );
    }

    /**
     * @param Text $text
     * @param $x1
     * @param $y1
     * @return ImageBuilder
     */
    public function addText(Text $text, $x1,$y1)
    {
        return $this->addCommand(TextAssetCommand::class,
            new TextCommandOption($text, new Coordinate($x1,$y1))
        );
    }

    /**
     * @param $x1
     * @param $y1
     * @param $x2
     * @param $y2
     * @param $color
     * @return ImageBuilder
     */
    public function addSquare($x1,$y1,$x2,$y2,$color){
        return $this->addCommand(SquareAssetCommand::class,
            new DoubleCoordinateColorCommandOption(
                new Coordinate($x1,$y1),
                new Coordinate($x2,$y2),
                $color)
        );

    }

    /**
     * @param Image $image
     * @param int $x
     * @param int $y
     * @return ImageBuilder
     */
    public function merge(Image $image, $x = 0, $y = 0)
    {
        $fileObject = FileTemp::fromString($image->toPNG());

        return $this->addCommand(ImageAssetCommand::class,
            new SingleCoordinateFileObjectCommandOption($fileObject, new Coordinate($x, $y))
        );
    }

    /**
     * @param $level
     * @return ImageBuilder
     */
    public function pixelate($level)
    {
        return $this->addCommand(PixelCommand::class,
            new LevelCommandOption($level)
        );
    }

    /**
     * @param $stroke
     * @param string $colorHex
     * @return ImageBuilder
     */
    public function border($stroke, $colorHex = 'FFFFFF')
    {
        return $this->addCommand(BorderCommand::class,
            new BorderCommandOption($stroke, $colorHex)
        );
    }

    /**
     * @param $newWidth
     * @param $newHeight
     * @return ImageBuilder
     * @throws \Exception
     */
    public function cropCenter($newWidth, $newHeight)
    {
        $width = $this->image->getWidth();
        $height = $this->image->getHeight();

        if ($newWidth > $width || $newHeight > $height) {
            throw new \Exception(sprintf('Crop area exceed, max dimensions are: %s X %s', $width, $height));
        }

        $x = ($width- $newWidth) / 2;
        $y = ($height - $newHeight) / 2;

        return $this->addCommand(CropCommand::class, new CropCommandOption(new Coordinate($x, $y), $newWidth, $newHeight));
    }

    public function brightness($level)
    {
        return $this->addCommand(BrightnessCommand::class,
            new LevelCommandOption($level)
        );
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
        return $this->addCommand(CropCommand::class,
            new CropCommandOption(new Coordinate($x, $y), $width, $height)
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

        return $this->addCommand(CropPolygonCommand::class,
            new MultiCoordinateCommandOption($coords)
        );
    }

    /**
     * @param null $width
     * @param null $height
     * @return $this
     * @throws \Exception
     */
    public function thumbnail($width = null, $height = null)
    {
        /** @var DimensionCommandOption $options */
        $options = new DimensionCommandOption($width,$height);

        if (!$options->getWidth() and !$options->getHeight()) {
            throw new \Exception('Both width and height are empy value');
        }

        if (!$options->getWidth()) {
            $options->add('width', $options->getWidth() ? $options->getWidth() : round($this->image->getAspectRatio() * $options->getHeight()));
        }

        if (!$options->getHeight()) {
            $options->add('height', $options->getHeight() ? $options->getHeight() : round($options->getWidth() / $this->image->getAspectRatio()));
        }

        $thumbAspect = $options->getWidth() / $options->getHeight();

        if ($this->image->getAspectRatio() >= $thumbAspect) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $newHeight = $options->getHeight();
            $newWidth = $this->image->getWidth() / ($this->image->getHeight() / $options->getHeight());
        } else {
            // If the thumbnail is wider than the image
            $newHeight = $this->image->getHeight() / ($this->image->getWidth() / $options->getWidth());
            $newWidth = $options->getWidth();
        }

        $this->resize($newWidth, $newHeight);
        $this->cropCenter($options->getWidth(), $options->getHeight());

        return $this;
    }

    /**
     * @return ImageBuilder
     */
    public function grayScale()
    {
        return $this->addCommand(GrayScaleCommand::class, null);
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }
}
