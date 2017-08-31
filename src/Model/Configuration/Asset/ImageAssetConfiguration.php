<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 30/08/17
 * Time: 12.38
 */

namespace Edimotive\ImageMerge\Model\Configuration\Asset;

class ImageAssetConfiguration
{
    protected $pathname;

    /**
     * @param $pathname
     * @return ImageAssetConfiguration
     */
    public static function fromFile($pathname)
    {
        $asset = new self($pathname);
        $asset->pathname =  $pathname;
        return $asset;
    }

    /**
     * @return string
     */
    public function getPathname()
    {
        return $this->pathname;
    }
}
