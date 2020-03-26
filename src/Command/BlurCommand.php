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
    /**
     * BlurCommand constructor.
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
        if ($this->options->get('level')) {
            for ($i = 0; $i < $this->options->get('level'); $i++) {
                imagefilter($image->getResource(), IMG_FILTER_GAUSSIAN_BLUR);
            }
        }

        return $image;
    }
}
