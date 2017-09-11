<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 18.57
 */

namespace Jackal\ImageMerge\Command\Options;

class AssetCommandOption extends AbstractCommandOption
{
    public function getAsset()
    {
        return $this->get('asset');
    }
}
