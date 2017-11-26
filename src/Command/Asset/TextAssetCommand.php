<?php

namespace Jackal\ImageMerge\Command\Asset;

use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\Options\TextCommandOption;
use Jackal\ImageMerge\Utils\ColorUtils;

/**
 * Class TextAssetCommand
 * @package Jackal\ImageMerge\Command\Asset
 */
class TextAssetCommand extends AbstractCommand
{
    /**
     * @return \Jackal\ImageMerge\Model\Image
     */
    public function execute()
    {
        /** @var TextCommandOption $options */
        $options = $this->options;

        $color = ColorUtils::colorIdentifier($this->image->getResource(),
            $options->getColor()
        );

        $fontPixel = round($options->getText()->getFontSize() * 0.75);

        imagettftext($this->image->getResource(), $fontPixel, 0,
            $options->getCoordinate1()->getX(),
            $options->getCoordinate1()->getY() + $fontPixel,
            $color, $options->getText()->getFont(), $options->getText()->getText());
        return $this->image;
    }
}
