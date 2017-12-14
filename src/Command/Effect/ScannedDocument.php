<?php

namespace Jackal\ImageMerge\Command\Effect;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Model\Image;

class ScannedDocument extends AbstractCommand
{
    /**
     * EffectBlurCentered constructor.
     * @param Image $image
     */
    public function __construct(Image $image)
    {
        parent::__construct($image, null);
    }

    /**
     * @return Image
     */
    public function execute()
    {
        $builder = ImageBuilder::fromImage($this->image);

        if($this->image->getWidth() > $this->image->getHeight()){
            $builder->rotate(-90);
        }

        $builder->grayScale();
        $builder->contrast(-80);

        return $builder->getImage();
    }
}