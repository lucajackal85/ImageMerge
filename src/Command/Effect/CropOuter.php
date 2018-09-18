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
     * @throws \Jackal\ImageMerge\Exception\InvalidColorException
     */
    public function execute()
    {
        $builder = new ImageBuilder($this->image);
        $width = $this->options->getDimention()->getWidth();
        $height = $this->options->getDimention()->getHeight();

        $thumbAspect = $width / $height;

        if ($this->image->getAspectRatio() >= $thumbAspect) {
            $builder->resize($width,null);
            $mergeX = 0;
            $mergeY = round(($height - $builder->getImage()->getHeight()) / 2);
        } else {
            $builder->resize(null,$height);
            $mergeX = round(($width - $builder->getImage()->getWidth()) / 2);
            $mergeY = 0;
        }

        $originalImg = $this->saveImage($builder->getImage());
        $builder = new ImageBuilder(new Image($width,$height,false));
        $builder->merge(Image::fromFile($originalImg), $mergeX, $mergeY);

        return $builder->getImage();
    }

    /**
     * @param Image $image
     * @return FileTempObject
     * @throws \Exception
     */
    private function saveImage(Image $image)
    {
        return FileTempObject::fromString($image->toPNG()->getContent());
    }
}