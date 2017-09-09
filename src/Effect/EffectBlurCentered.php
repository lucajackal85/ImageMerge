<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 08/09/17
 * Time: 15.39
 */

namespace Jackal\ImageMerge\Effect;

use Jackal\ImageMerge\Model\Asset\ImageAsset;
use Jackal\ImageMerge\Model\Configuration\ImageConfiguration;
use Jackal\ImageMerge\Model\Image;

class EffectBlurCentered implements EffectInterface
{
    private $outputWidth;
    private $outputHeight;

    public function __construct($outputWidth, $outputHeight)
    {
        $this->outputWidth = $outputWidth;
        $this->outputHeight = $outputHeight;
    }

    /**
     * @param Image $image
     * @return Image
     */
    public function execute(Image $image, ImageConfiguration $imageConfiguration)
    {
        $originalImg = $this->saveImage($image);

        $image->resize($this->outputWidth, $this->outputHeight);
        $image->blur(30);

        $x = ($this->outputWidth - $imageConfiguration->getWidth()) / 2;
        $y = ($this->outputHeight - $imageConfiguration->getHeight()) / 2;

        $imageConfiguration->addAsset(new ImageAsset($originalImg, $x, $y));


        return $image;
    }

    private function saveImage(Image $image)
    {
        $originalImgPath = '/var/www/data/y.jpg';
        $image->toFile($originalImgPath);
        return new \SplFileObject($originalImgPath);
    }
}
