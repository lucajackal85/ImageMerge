<?php

namespace Jackal\ImageMerge\Command\Effect;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use Jackal\ImageMerge\Model\Image;

class ScannedDocument extends AbstractCommand
{
    private readonly LevelCommandOption $contrast;

    /**
     * ScannedDocument constructor.
     */
    public function __construct(?LevelCommandOption $contrast = null)
    {
        $this->contrast = $contrast ?? new LevelCommandOption(-60);

        parent::__construct($this->contrast);
    }

    public function execute(Image $image): Image
    {
        $builder = new ImageBuilder($image);

        if ($image->getWidth() > $image->getHeight()) {
            $builder->rotate(-90);
        }

        $builder->grayScale();
        $builder->contrast($this->contrast->getLevel());

        return $builder->getImage();
    }
}
