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
        $degree = $this->options->getLevel();
        $resource = $image->getResource();
        if ($degree and ($degree % 360)) {
            $resource = imagerotate($resource, $degree, 0);
        }
        return $image->assignResource($resource);
    }
}
