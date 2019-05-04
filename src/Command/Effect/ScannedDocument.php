<?php

namespace Jackal\ImageMerge\Command\Effect;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use Jackal\ImageMerge\Model\Image;

class ScannedDocument extends AbstractCommand
{
    /**
     * @var LevelCommandOption
     */
    private $contrast;

    /**
     * ScannedDocument constructor.
     * @param LevelCommandOption|null $contrast
     */
    public function __construct(LevelCommandOption $contrast = null)
    {
        if ($contrast == null) {
            $this->contrast = new LevelCommandOption(-60);
        }

        parent::__construct($this->contrast);
    }

    /**
     * @param Image $image
     * @return Image
     */
    public function execute(Image $image)
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
