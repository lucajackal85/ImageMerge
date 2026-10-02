<?php

namespace Jackal\ImageMerge\Command\Effect;

use Exception;
use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Exception\InvalidColorException;
use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\Model\File\FileTempObject;
use Jackal\ImageMerge\Model\Image;

/**
 * Class EffectBlurCentered
 * @package Jackal\ImageMerge\Command\Effect
 */
class EffectBlurCentered extends AbstractCommand
{
    /**
     * EffectBlurCentered constructor.
     */
    public function __construct(DimensionCommandOption $options)
    {
        parent::__construct($options);
    }

    /**
     * @throws InvalidColorException
     */
    public function execute(Image $image): Image
    {
        /** @var DimensionCommandOption $options */
        $options = $this->options;

        $builder = new ImageBuilder($image);

        $originalWidth = $image->getWidth();
        $originalHeight = $image->getHeight();

        if ($originalHeight > $options->getDimension()->getHeight()) {
            $builder->thumbnail(null, $options->getDimension()->getHeight() - 4);
            $originalWidth = $image->getWidth();
            $originalHeight = $image->getHeight();
        }

        if ($originalWidth > $options->getDimension()->getWidth()) {
            $builder->thumbnail($options->getDimension()->getWidth() - 4);
            $originalWidth = $image->getWidth();
            $originalHeight = $image->getHeight();
        }

        $originalImg = $this->saveImage($image);

        $builder->resize($options->getDimension()->getWidth(), $options->getDimension()->getHeight());
        $builder->blur(40);
        $builder->brightness(-70);

        $x = round(($options->getDimension()->getWidth() - $originalWidth) / 2);
        $y = round(($options->getDimension()->getHeight() - $originalHeight) / 2);

        $borderColor = Color::WHITE;

        $builder->addSquare($x - 1, $y - 1, $x + $originalWidth, $y + $originalHeight, $borderColor);

        $builder->merge(Image::fromFile($originalImg), $x, $y);

        return $builder->getImage();
    }

    /**
     * @throws Exception
     */
    private function saveImage(Image $image): FileTempObject
    {
        return FileTempObject::fromString($image->toPNG()->getContent());
    }
}
