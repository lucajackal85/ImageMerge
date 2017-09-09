<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 9.54
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Model\Asset\AssetInterface;
use Jackal\ImageMerge\Model\Image;

class AssetCommand implements CommandInterface
{
    /**
     * @var Image
     */
    private $image;

    /**
     * @var AssetInterface
     */
    private $asset;

    /**
     * AssetCommand constructor.
     * @param Image $image
     * @param AssetInterface $asset
     */
    public function __construct(Image $image, AssetInterface $asset)
    {
        $this->image = $image;
        $this->asset = $asset;
    }

    public function execute()
    {
        $this->asset->applyToResource($this->image->getResource());
        return $this->image;
    }
}
