<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 30/08/17
 * Time: 12.40
 */

namespace Jackal\ImageMerge\Model\Asset;

use Jackal\ImageMerge\Model\Format\ImageReader;

/**
 * Class ImageAsset
 * @package Jackal\ImageMerge\Model\Asset
 */
class ImageAsset implements AssetInterface
{
    /**
     * @var \SplFileObject
     */
    protected $fileObject;

    protected $x;

    protected $y;

    /**
     * @param \SplFileObject $fileObject
     * @param null $x
     * @param null $y
     * @return ImageAsset
     */
    public static function fromFile(\SplFileObject $fileObject,$x = null,$y = null)
    {
        $ia = new self();
        $ia->fileObject = $fileObject;
        $ia->x = (int)$x;
        $ia->y = (int)$y;

        return $ia;
    }

    protected function getResource()
    {
        $res = ImageReader::fromPathname($this->fileObject);
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
