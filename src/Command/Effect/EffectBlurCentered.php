<?php

namespace Jackal\ImageMerge\Command\Effect;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\Model\File\FileTempObject;
use Jackal\ImageMerge\Model\Image;

/**
 * Class EffectBlurCentered
 * @package Jackal\ImageMerge\Command\Effect
 */
class EffectBlurCentered extends AbstractCommand
{

    const CLASSNAME = __CLASS__;

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
     * @throws \Exception
     * @throws \Jackal\ImageMerge\Exception\InvalidColorException
     */
    public function execute()
    {
        /** @var DimensionCommandOption $options */
        $options = $this->options;

        $builder = ImageBuilder::fromImage($this->image);

        $originalWidth = $this->image->getWidth();
        $originalHeight = $this->image->getHeight();

        if ($originalHeight > $options->getHeight()) {
            $builder->thumbnail(null, $options->getHeight() - 4);
            $originalWidth = $this->image->getWidth();
            $originalHeight = $this->image->getHeight();
        }

        if ($originalWidth > $options->getWidth()) {
            $builder->thumbnail($options->getWidth() - 4, null);
            $originalWidth = $this->image->getWidth();
            $originalHeight = $this->image->getHeight();
        }

        $originalImg = $this->saveImage($this->image);

        $builder->resize($options->getWidth(), $options->getHeight());
        $builder->blur(40);
        $builder->brightness(-70);

        $x = round(($options->getWidth() - $originalWidth) / 2);
        $y = round(($options->getHeight() - $originalHeight) / 2);

        $borderColor = Color::WHITE;

        $builder->addSquare($x - 1, $y - 1,$x + $originalWidth, $y + $originalHeight,$borderColor);

        $builder->merge(Image::fromFile($originalImg),$x, $y);

        return $builder->getImage();
    }

    /**
     * @param Image $image
     * @return FileTempObject
     */
    private function saveImage(Image $image)
    {
        return FileTempObject::fromString($image->toPNG()->getBody());
    }
}
