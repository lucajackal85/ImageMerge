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

    /**
     * PixelCommand constructor.
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
        $level = $this->options->getLevel();
        if (!$level) {
            return $image;
        }

        $resource = $image->getResource();

        // start from the top-left pixel and keep looping until we have the desired effect
        for ($y = 0;$y < $image->getHeight();$y += $level+1) {
            for ($x = 0;$x < $image->getWidth();$x += $level+1) {
                // get the color for current pixel
                $rgb = imagecolorsforindex($resource, imagecolorat($resource, $x, $y));

                // get the closest color from palette
                $color = imagecolorclosest($resource, $rgb['red'], $rgb['green'], $rgb['blue']);
                imagefilledrectangle($resource, $x, $y, $x+$level, $y+$level, $color);
            }
        }

        return $image;
    }
}
