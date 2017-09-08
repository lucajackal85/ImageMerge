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
    public function execute(Image $image)
    {
        $originalImg = $this->saveImage($image);

        $image->resize($this->outputWidth, $this->outputHeight);
        $image->blur(50);
        $image = $this->saveImage($image);

        $x = $this->getXCenter($originalImg, $image);
        $y = $this->getYCenter($originalImg, $image);

        $newImageConfiguration = ImageConfiguration::fromFile($image);
        $newImageConfiguration->addAsset(new ImageAsset($originalImg, $x, $y));
        $newImg = new Image($newImageConfiguration);

        return $newImg;
    }

    private function getXCenter(\SplFileObject $fileForeground, \SplFileObject $fileBackground)
    {
        return $this->getXYCenter($fileForeground, $fileBackground)[0];
    }

    private function getYCenter(\SplFileObject $fileForeground, \SplFileObject $fileBackground)
    {
        return $this->getXYCenter($fileForeground, $fileBackground)[1];
    }

    private function getXYCenter(\SplFileObject $fileForeground, \SplFileObject $fileBackground)
    {
        $fileBackgroundSize = getimagesize($fileBackground->getPathname());
        $fileForegroundSize = getimagesize($fileForeground->getPathname());

        return [
            round(($fileBackgroundSize[0] - $fileForegroundSize[0]) /2),
            round(($fileBackgroundSize[1] - $fileForegroundSize[1]) /2),
        ];
    }

    private function saveImage(Image $image)
    {
        $originalImgPath = tempnam(sys_get_temp_dir(), 'tmp_');
        if (!file_put_contents($originalImgPath, $image->dump())) {
            throw new \Exception('Errore creating file');
        }
        return new \SplFileObject($originalImgPath);
    }
}
