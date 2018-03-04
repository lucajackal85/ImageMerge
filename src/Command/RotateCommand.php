<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use Jackal\ImageMerge\Model\Image;

/**
 * Class RotateCommand
 * @package Jackal\ImageMerge\Command
 */
class RotateCommand extends AbstractCommand
{

    /**
     * RotateCommand constructor.
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
        $degree = $this->options->getLevel();
        $resource = $this->image->getResource();
        if ($degree and ($degree % 360)) {
            $resource = imagerotate($resource, $degree, 0);
        }
        return $this->image->assignResource($resource);
    }
}
