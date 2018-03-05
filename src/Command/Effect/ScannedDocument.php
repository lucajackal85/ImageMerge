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
     * @param Image $image
     * @param LevelCommandOption|null $contrast
     */
    public function __construct(Image $image, LevelCommandOption $contrast = null)
    {
        if ($contrast == null) {
            $this->contrast = new LevelCommandOption(80);
        }

        parent::__construct($image, $this->contrast);
    }

    /**
     * @return Image
     * @throws \Exception
     */
    public function execute()
    {
        $builder = new ImageBuilder($this->image);

        if ($this->image->getWidth() > $this->image->getHeight()) {
            $builder->rotate(-90);
        }

        $builder->grayScale();
        $builder->contrast($this->contrast->getLevel());

        return $builder->getImage();
    }
}
