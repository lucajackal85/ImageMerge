<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 18.57
 */

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Asset\AssetInterface;

class AssetCommandOption extends AbstractCommandOption
{
    public function __construct(AssetInterface $asset)
    {
        $this->add('asset', $asset);
    }

    public function getAsset()
    {
        return $this->get('asset');
    }
}
