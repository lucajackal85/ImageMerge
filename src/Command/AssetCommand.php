<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 9.54
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\AssetCommandOption;
use Jackal\ImageMerge\Model\Asset\AssetInterface;

class AssetCommand extends AbstractCommand
{

    public function execute()
    {
        /** @var AssetCommandOption $asset */
        $asset = $this->options->getAsset();
        $asset->applyToResource($this->image->getResource());
        return $this->image;
    }
}
