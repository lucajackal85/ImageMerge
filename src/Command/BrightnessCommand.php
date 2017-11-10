<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 14/09/17
 * Time: 15.12
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\AbstractCommandOption;
use Jackal\ImageMerge\Command\Options\CommandOptionInterface;
use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use Jackal\ImageMerge\Model\Image;

class BrightnessCommand extends AbstractCommand
{
    public function __construct(Image $image, LevelCommandOption $options)
    {
        parent::__construct($image, $options);
    }


    /**
     * @return Image
     */
    public function execute()
    {
        imagefilter($this->image->getResource(), IMG_FILTER_BRIGHTNESS, $this->options->getLevel());

        return $this->image;
    }
}
