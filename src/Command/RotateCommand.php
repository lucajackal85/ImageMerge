<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use Jackal\ImageMerge\Model\Image;
use RuntimeException;

/**
 * Class RotateCommand
 * @package Jackal\ImageMerge\Command
 */
class RotateCommand extends AbstractCommand
{
    /**
     * RotateCommand constructor.
     */
    public function __construct(LevelCommandOption $options)
    {
        parent::__construct($options);
    }

    public function execute(Image $image): Image
    {
        $degree = fmod((float) $this->options->getLevel(), 360);
        if ($degree == 0) {
            return $image;
        }

        $resource = $image->getResource();
        imagesavealpha($resource, true);
        $transparent = imagecolorallocatealpha($resource, 0, 0, 0, 127);
        $rotated = imagerotate($resource, $degree, $transparent);
        if ($rotated === false) {
            throw new RuntimeException('Unable to rotate image');
        }
        imagesavealpha($rotated, true);

        return $image->assignResource($rotated);
    }
}
