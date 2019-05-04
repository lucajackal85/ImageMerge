<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use Jackal\ImageMerge\Model\Image;

/**
 * Class BrightnessCommand
 * @package Jackal\ImageMerge\Command
 */
class BrightnessCommand extends AbstractCommand
{
    /**
     * BrightnessCommand constructor.
     * @param LevelCommandOption $options
     */
    public function __construct(LevelCommandOption $options)
    {
        parent::__construct($options);
    }


    /**
     * @param Image $image
     * @return Image
     */
    public function execute(Image $image)
    {
        imagefilter($image->getResource(), IMG_FILTER_BRIGHTNESS, $this->options->getLevel());

        return $image;
    }
}
