<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 08/09/17
 * Time: 23.47
 */

namespace Jackal\ImageMerge\Effect;

use Jackal\ImageMerge\Model\Asset\LineAsset;
use Jackal\ImageMerge\Model\Configuration\ImageConfiguration;
use Jackal\ImageMerge\Model\Image;

class EffectBorder implements EffectInterface
{
    private $borderWidth;

    private $colorHex;

    public function __construct($borderWidth, $colorHex = '000000')
    {
        $this->borderWidth = $borderWidth;
        $this->colorHex = $colorHex;
    }


    public function execute(Image $image, ImageConfiguration $imageConfiguration)
    {
        for ($i=0;$i<$this->borderWidth;$i++) {
            //top
            $imageConfiguration->addAsset(
                new LineAsset(
                    0,
                    $i,
                    $imageConfiguration->getOutputWidth(),
                    $i,
                    $this->colorHex
                )
            );
            //bottom
            $imageConfiguration->addAsset(
                new LineAsset(
                    0,
                    $imageConfiguration->getOutputHeight() - $i,
                    $imageConfiguration->getOutputWidth(),
                    $imageConfiguration->getOutputHeight() - $i,
                    $this->colorHex
                )
            );
            //right
            $imageConfiguration->addAsset(
                new LineAsset(
                    $imageConfiguration->getOutputWidth() - $i,
                    0,
                    $imageConfiguration->getOutputWidth() - $i,
                    $imageConfiguration->getOutputHeight(),
                    $this->colorHex
                )
            );
            //left
            $imageConfiguration->addAsset(
                 new LineAsset(
                    $i,
                    0,
                    $i,
                    $imageConfiguration->getOutputHeight(),
                     $this->colorHex
                 )
            );
        }


        return $image;
    }
}
