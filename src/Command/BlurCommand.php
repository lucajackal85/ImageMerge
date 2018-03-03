<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use Jackal\ImageMerge\Model\Image;

/**
 * Class BlurCommand
 * @package Jackal\ImageMerge\Command
 */
class BlurCommand extends AbstractCommand
{
    const CLASSNAME = __CLASS__;

    /**
     * BlurCommand constructor.
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
        if ($this->options->get('level')) {
            for ($i = 0; $i < $this->options->get('level'); $i++) {
                imagefilter($this->image->getResource(), IMG_FILTER_GAUSSIAN_BLUR);
            }
        }
        return $this->image;
    }
}
