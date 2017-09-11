<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 0.15
 */

namespace Jackal\ImageMerge\Command\Asset;

use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\Options\DoubleCoordinateColorCommandOption;
use Jackal\ImageMerge\Utils\ColorUtils;

class LineAsset extends AbstractCommand
{
    public function execute()
    {
        /** @var DoubleCoordinateColorCommandOption $options */
        $options = $this->options;
        $color = imagecolorallocate($this->image->getResource(), $options->getColorRed(), $options->getColorGreen(), $options->getColorBlue());
        imageline($this->image->getResource(), $options->getX1(), $options->getY1(), $options->getX2(), $options->getY2(), $color);
    }
}
