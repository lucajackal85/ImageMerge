<?php

namespace Jackal\ImageMerge\Command\Asset;

use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\Options\DoubleCoordinateColorCommandOption;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\Utils\ColorUtils;

/**
 * Class LineAssetCommand
 * @package Jackal\ImageMerge\Command\Asset
 */
class LineAssetCommand extends AbstractCommand
{

    /**
     * @param Image $image
     * @return Image
     */
    public function execute(Image $image)
    {
        /** @var DoubleCoordinateColorCommandOption $options */
        $options = $this->options;
        $color = ColorUtils::colorIdentifier($image->getResource(), $options->getColor());
        imageline($image->getResource(),
            $options->getCoordinate1()->getX(),
            $options->getCoordinate1()->getY(),
            $options->getCoordinate2()->getX(),
            $options->getCoordinate2()->getY(), $color
        );

        return $image;
    }
}
