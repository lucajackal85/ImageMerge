<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 08/09/17
 * Time: 15.39
 */

namespace Jackal\ImageMerge\Effect;

use Jackal\ImageMerge\Model\Asset\ImageAsset;
use Jackal\ImageMerge\Model\Asset\SquareAsset;
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
    public function execute(Image $image)
    {
        $originalWidth = $image->getWidth();
        $originalHeight = $image->getHeight();
        $originalImg = $this->saveImage($image);

        $image->resize($this->outputWidth, $this->outputHeight);
        $image->blur(40);

        $x = round(($this->outputWidth - $originalWidth) / 2);
        $y = round(($this->outputHeight - $originalHeight) / 2);

        $stroke = 2;

        $image->addAsset(new SquareAsset($stroke, $x - $stroke - 1 , $y - $stroke - 1, $x + $originalWidth + $stroke, $y + $originalHeight + $stroke,'CCCCCC'));
        $image->addAsset(new ImageAsset($originalImg, $x, $y));

        return $image;
    }

    private function saveImage(Image $image)
    {
        $originalImgPath = '/var/www/data/y.jpg';
        $image->toPNG($originalImgPath);
        return new \SplFileObject($originalImgPath);
    }
}
