<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 30/08/17
 * Time: 16.42
 */

namespace Jackal\ImageMerge\Model\Asset;


interface AssetInterface
{
    public function applyToResource($resource);
}