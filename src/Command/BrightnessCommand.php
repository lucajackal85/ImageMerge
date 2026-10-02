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
     */
    public function __construct(LevelCommandOption $options)
    {
        parent::__construct($options);
    }

    public function execute(Image $image): Image
    {
        imagefilter($image->getResource(), IMG_FILTER_BRIGHTNESS, $this->options->getLevel());

        return $image;
    }
}
