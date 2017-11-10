<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 11.59
 */

namespace Jackal\ImageMerge\Command\Asset;

use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\Options\DoubleCoordinateColorCommandOption;
use Jackal\ImageMerge\Utils\ColorUtils;

class SquareAssetCommand extends AbstractCommand
{
    public function execute()
    {
        /** @var DoubleCoordinateColorCommandOption $options */
        $options = $this->options;

        $color = ColorUtils::colorIdentifier($this->image->getResource(), $options->getColor());
        imagefilledrectangle($this->image->getResource(),
            $options->getCoordinate1()->getX(),
            $options->getCoordinate1()->getY(),
            $options->getCoordinate2()->getX(),
            $options->getCoordinate2()->getY(), $color
        );

        return $this->image;
    }
}
