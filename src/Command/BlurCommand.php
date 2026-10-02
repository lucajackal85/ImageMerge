<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use Jackal\ImageMerge\Limits;
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
        $level = (int) $this->options->getLevel();
        Limits::default()->assertBlurLevel($level);

        if ($level > 0) {
            for ($i = 0; $i < $level; $i++) {
                imagefilter($image->getResource(), IMG_FILTER_GAUSSIAN_BLUR);
            }
        }

        return $image;
    }
}
