<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 9.54
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\AssetCommandOption;
use Jackal\ImageMerge\Model\Image;

class AssetCommand extends AbstractCommand
{
    public function __construct(Image $image, AssetCommandOption $options)
    {
        parent::__construct($image, $options);
    }

    public function execute()
    {
        /** @var AssetCommandOption $option */
        $option = $this->options;

        $asset = $option->getAsset();
        $asset->applyToResource($this->image->getResource());
        return $this->image;
    }
}
