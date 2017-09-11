<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 12.38
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use Jackal\ImageMerge\Model\Image;

class PixelCommand extends AbstractCommand
{
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
