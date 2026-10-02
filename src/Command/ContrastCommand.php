<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use Jackal\ImageMerge\Model\Image;

class ContrastCommand extends AbstractCommand
{
    /**
     * ContrastCommand constructor.
     */
    public function __construct(LevelCommandOption $options)
    {
        parent::__construct($options);
    }

    public function execute(Image $image): Image
    {
        imagefilter($image->getResource(), IMG_FILTER_CONTRAST, $this->options->getLevel());

        return $image;
    }
}
