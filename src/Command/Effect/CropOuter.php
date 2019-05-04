<?php


namespace Jackal\ImageMerge\Command\Effect;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Model\File\FileTempObject;
use Jackal\ImageMerge\Model\Image;

class CropOuter extends AbstractCommand
{

    /**
     * EffectBlurCentered constructor.
     * @param Image $image
     * @param DimensionCommandOption $options
     */
    public function __construct(Image $image, DimensionCommandOption $options)
    {
        parent::__construct($image, $options);
    }

    /**
     * @return Image
     * @throws \Exception
     */
    public function execute()
    {
        $newWidth = $this->options->getDimention()->getWidth();
        $newHeight = $this->options->getDimention()->getHeight();

        $thumbAspect = $newWidth / $newHeight;
        $builder = new ImageBuilder($this->image);
        if ($this->image->getAspectRatio() >= $thumbAspect) {
            $builder->resize($newWidth, null);
        } else {
            $builder->resize(null, $newHeight);
        }

        $posX = ($newWidth - $this->image->getWidth()) / 2;
        $posY = ($newHeight - $this->image->getHeight()) / 2;

        $image_p = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($image_p, $this->image->getResource(), $posX, $posY, 0, 0, $this->image->getWidth(), $this->image->getHeight(), $this->image->getWidth(), $this->image->getHeight());

        $this->image->assignResource($image_p);

        return $this->image;
    }
}
