<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 30/08/17
 * Time: 12.40
 */

namespace Edimotive\ImageMerge\Model\Asset;

use Edimotive\ImageMerge\Model\Configuration\Asset\ImageAssetConfiguration;
use Edimotive\ImageMerge\Model\Format\ImageReader;

class ImageAsset implements AssetInterface
{
    /**
     * @var ImageAssetConfiguration
     */
    protected $assetConfiguration;

    protected $x;

    protected $y;

    /**
     * ImageAsset constructor.
     * @param ImageAssetConfiguration $assetConfiguration
     * @param int $x
     * @param int $y
     */
    public function __construct(ImageAssetConfiguration $assetConfiguration,$x = null,$y = null)
    {
        $this->assetConfiguration = $assetConfiguration;
        $this->x = (int)$x;
        $this->y = (int)$y;
    }

    protected function getResource()
    {
        $res = ImageReader::fromPathname($this->assetConfiguration->getPathname());
        return $res->getResource();
    }

    protected function getWidth()
    {
        return imagesx($this->getResource());
    }

    protected function getHeight()
    {
        return imagesy($this->getResource());
    }

    public function applyToResource($resource)
    {
        //imagecopymerge($resource, $this->getResource(), $this->x, $this->y, 0, 0, $this->getWidth(), $this->getHeight(), 100);
        imagecolortransparent($resource);
        imagecopyresampled($resource,$this->getResource(),$this->x, $this->y, 0, 0, $this->getWidth(), $this->getHeight(),$this->getWidth(), $this->getHeight());
        return $resource;
    }
}
