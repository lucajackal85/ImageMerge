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


    public function execute(Image $image)
    {
        for ($i=0;$i<$this->borderWidth;$i++) {
            //top
            $image->addAsset(
                new LineAsset(
                    0,
                    $i,
                    $image->getWidth(),
                    $i,
                    $this->colorHex
                )
            );
            //bottom
            $image->addAsset(
                new LineAsset(
                    0,
                    $image->getHeight() - $i - 1,
                    $image->getWidth(),
                    $image->getHeight() - $i - 1,
                    $this->colorHex
                )
            );
            //right
            $image->addAsset(
                new LineAsset(
                    $image->getWidth() - $i -1,
                    0,
                    $image->getWidth() - $i -1,
                    $image->getHeight(),
                    $this->colorHex
                )
            );
            //left
            $image->addAsset(
                 new LineAsset(
                    $i,
                    0,
                    $i,
                    $image->getHeight(),
                     $this->colorHex
                 )
            );
        }


        return $image;
    }
}
