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
     * @param DimensionCommandOption $options
     */
    public function __construct(DimensionCommandOption $options)
    {
        parent::__construct($options);
    }

    /**
     * @param Image $image
     * @return Image
     * @throws InvalidColorException
     */
    public function execute(Image $image)
    {
        /** @var DimensionCommandOption $options */
        $options = $this->options;

        $builder = new ImageBuilder($image);

        $originalWidth = $image->getWidth();
        $originalHeight = $image->getHeight();

        if ($originalHeight > $options->getDimention()->getHeight()) {
            $builder->thumbnail(null, $options->getDimention()->getHeight() - 4);
            $originalWidth = $image->getWidth();
            $originalHeight = $image->getHeight();
        }

        if ($originalWidth > $options->getDimention()->getWidth()) {
            $builder->thumbnail($options->getDimention()->getWidth() - 4, null);
            $originalWidth = $image->getWidth();
            $originalHeight = $image->getHeight();
        }

        $originalImg = $this->saveImage($image);

        $builder->resize($options->getDimention()->getWidth(), $options->getDimention()->getHeight());
        $builder->blur(40);
        $builder->brightness(-70);

        $x = round(($options->getDimention()->getWidth() - $originalWidth) / 2);
        $y = round(($options->getDimention()->getHeight() - $originalHeight) / 2);

        $borderColor = Color::WHITE;

        $builder->addSquare($x - 1, $y - 1, $x + $originalWidth, $y + $originalHeight, $borderColor);

        $builder->merge(Image::fromFile($originalImg), $x, $y);

        return $builder->getImage();
    }

    /**
     * @param Image $image
     * @return FileTempObject
     * @throws Exception
     */
    private function saveImage(Image $image)
    {
        return FileTempObject::fromString($image->toPNG()->getContent());
    }
}
