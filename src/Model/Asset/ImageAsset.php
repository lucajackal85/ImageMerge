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
     * ImageAsset constructor.
     * @param \SplFileObject|string $fileObject
     * @param null $x
     * @param null $y
     */
    public function __construct($fileObject, $x = null, $y = null)
    {
        if (!$fileObject instanceof \SplFileObject) {
            $fileObject = new \SplFileObject($fileObject);
        }

        $this->fileObject = $fileObject;
        $this->x = (int)$x;
        $this->y = (int)$y;

        return $this;
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
        imagecolortransparent($resource);
        imagecopyresampled($resource, $this->getResource(), $this->x, $this->y, 0, 0, $this->getWidth(), $this->getHeight(), $this->getWidth(), $this->getHeight());
        return $resource;
    }
}
