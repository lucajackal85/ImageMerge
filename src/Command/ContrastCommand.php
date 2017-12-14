<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use Jackal\ImageMerge\Model\Image;

class ContrastCommand extends AbstractCommand
{
    /**
     * ContrastCommand constructor.
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
        imagefilter($this->image->getResource(), IMG_FILTER_CONTRAST, $this->options->getLevel());

        return $this->image;
    }
}