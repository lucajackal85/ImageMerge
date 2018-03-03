<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use Jackal\ImageMerge\Model\Image;

/**
 * Class PixelCommand
 * @package Jackal\ImageMerge\Command
 */
class PixelCommand extends AbstractCommand
{

    const CLASSNAME = __CLASS__;

    /**
     * PixelCommand constructor.
     * @param Image $image
     * @param LevelCommandOption $options
     */
    public function __construct(Image $image, LevelCommandOption $options)
    {
        parent::__construct($image, $options);
    }

    /**
     * @return Image
     */
    public function execute()
    {
        $level = $this->options->getLevel();
        if (!$level) {
            return $this->image;
        }

        $resource = $this->image->getResource();

        // start from the top-left pixel and keep looping until we have the desired effect
        for ($y = 0;$y < $this->image->getHeight();$y += $level+1) {
            for ($x = 0;$x < $this->image->getWidth();$x += $level+1) {
                // get the color for current pixel
                $rgb = imagecolorsforindex($resource, imagecolorat($resource, $x, $y));

                // get the closest color from palette
                $color = imagecolorclosest($resource, $rgb['red'], $rgb['green'], $rgb['blue']);
                imagefilledrectangle($resource, $x, $y, $x+$level, $y+$level, $color);
            }
        }

        return $this->image;
    }
}
