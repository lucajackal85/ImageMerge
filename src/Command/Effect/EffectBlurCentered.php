<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 08/09/17
 * Time: 15.39
 */

namespace Jackal\ImageMerge\Command\Effect;

use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\CommandInterface;
use Jackal\ImageMerge\Command\Options\CommandOptionInterface;
use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Command\Options\DoubleCoordinateColorStrokeCommandOption;
use Jackal\ImageMerge\Command\Options\SingleCoordinateFileObjectCommandOption;
use Jackal\ImageMerge\Command\Asset\ImageAssetCommand;
use Jackal\ImageMerge\Command\Asset\SquareAssetCommand;
use Jackal\ImageMerge\Model\Image;

class EffectBlurCentered extends AbstractCommand
{
    /**
     * EffectBlurCentered constructor.
     * @param Image $image
     * @param DimensionCommandOption $options
     */
    public function __construct(Image $image, DimensionCommandOption $options)
    {
        parent::__construct($image, $options);
    }

    /**
     * @return Image
     */
    public function execute()
    {
        /** @var DimensionCommandOption $options */
        $options = $this->options;

        $originalWidth = $this->image->getWidth();
        $originalHeight = $this->image->getHeight();

        if ($originalHeight > $options->getHeight()) {
            $this->image->thumbnail(null, $options->getHeight() - 4);
            $originalWidth = $this->image->getWidth();
            $originalHeight = $this->image->getHeight();
        }

        if ($originalWidth > $options->getWidth()) {
            $this->image->thumbnail($options->getWidth() - 4, null);
            $originalWidth = $this->image->getWidth();
            $originalHeight = $this->image->getHeight();
        }

        $originalImg = $this->saveImage($this->image);

        $this->image->resize($options->getWidth(), $options->getHeight());
        $this->image->blur(40);
        $this->image->brightness(-70);

        $x = round(($options->getWidth() - $originalWidth) / 2);
        $y = round(($options->getHeight() - $originalHeight) / 2);

        $borderColor = 'FFFFFF';

        $this->image->addCommand(SquareAssetCommand::class, new DoubleCoordinateColorStrokeCommandOption($x - 1, $y - 1, $x + $originalWidth, $y + $originalHeight, 0, $borderColor));
        $this->image->addCommand(ImageAssetCommand::class, new SingleCoordinateFileObjectCommandOption($originalImg, $x, $y));

        unlink($originalImg->getPathname());

        return $this->image;
    }

    /**
     * @param Image $image
     * @return \SplFileObject
     */
    private function saveImage(Image $image)
    {
        $originalImgPath = sys_get_temp_dir().'/'.uniqid('tmp_');
        $image->toPNG($originalImgPath);
        return new \SplFileObject($originalImgPath);
    }
}
