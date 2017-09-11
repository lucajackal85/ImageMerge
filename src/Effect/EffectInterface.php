<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 08/09/17
 * Time: 15.39
 */

namespace Jackal\ImageMerge\Effect;

use Jackal\ImageMerge\Model\Image;

interface EffectInterface
{
    public function execute(Image $image);
}