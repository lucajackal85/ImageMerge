<?php

namespace Jackal\ImageMerge\Command\Asset;

use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\Options\DoubleCoordinateColorCommandOption;
use Jackal\ImageMerge\Utils\ColorUtils;

/**
 * Class SquareAssetCommand
 * @package Jackal\ImageMerge\Command\Asset
 */
class SquareAssetCommand extends AbstractCommand
{
    const CLASSNAME = __CLASS__;

    /**
     * @return \Jackal\ImageMerge\Model\Image
     */
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
