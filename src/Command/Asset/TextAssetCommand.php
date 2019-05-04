<?php

namespace Jackal\ImageMerge\Command\Asset;

use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\Options\TextCommandOption;
use Jackal\ImageMerge\Exception\ModuleNotFoundException;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\Utils\ColorUtils;

/**
 * Class TextAssetCommand
 * @package Jackal\ImageMerge\Command\Asset
 */
class TextAssetCommand extends AbstractCommand
{

    /**
     * @param Image $image
     * @return mixed
     * @throws ModuleNotFoundException
     */
    public function execute(Image $image)
    {
        /** @var TextCommandOption $options */
        $options = $this->options;

        $color = ColorUtils::colorIdentifier($image->getResource(),
            $options->getColor()
        );

        $fontPixel = round($options->getText()->getFontSize() * 0.75);

        if (!function_exists('imagettftext')) {
            throw new ModuleNotFoundException('function imagettftext not installed');
        }

        imagettftext($image->getResource(), $fontPixel, 0,
            $options->getCoordinate1()->getX(),
            $options->getCoordinate1()->getY() + $fontPixel,
            $color, $options->getText()->getFont(), $options->getText()->getText());
        return $image;
    }
}
