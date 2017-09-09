<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 10.05
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Model\Image;

class ResizeCommand implements CommandInterface
{
    private $image;
    private $width;
    private $height;

    public function __construct(Image $image, $width, $height)
    {
        $this->width = $width;
        $this->height = $height;
        $this->image = $image;
    }

    public function execute()
    {
        if ($this->image->getWidth() != $this->width or $this->image->getHeight() != $this->height) {
            $resourceResized = imagecreatetruecolor($this->width, $this->height);
            imagecolortransparent($resourceResized);
            imagecopyresampled($resourceResized, $this->image->getResource(), 0, 0, 0, 0, $this->width, $this->height, $this->image->getWidth(), $this->image->getHeight());

            return $this->image->assignResource($resourceResized);
        }
        return $this->image;
    }
}
