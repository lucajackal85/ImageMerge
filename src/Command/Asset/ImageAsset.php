<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 30/08/17
 * Time: 12.40
 */

namespace Jackal\ImageMerge\Command\Asset;

use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\Options\SingleCoordinateFileObjectCommandOption;
use Jackal\ImageMerge\Model\Format\ImageReader;

/**
 * Class ImageAsset
 * @package Jackal\ImageMerge\Model\Asset
 */
class ImageAsset extends AbstractCommand
{
    protected function getResourceToApply()
    {
        $res = ImageReader::fromPathname($this->options->getFileObject());
        return $res->getResource();
    }

    protected function getWidth()
    {
        return imagesx($this->getResourceToApply());
    }

    protected function getHeight()
    {
        return imagesy($this->getResourceToApply());
    }

    public function execute()
    {
        /** @var SingleCoordinateFileObjectCommandOption $options */
        $options = $this->options;
        imagecolortransparent($this->image->getResource());
        imagecopyresampled($this->image->getResource(), $this->getResourceToApply(), $options->getX1(), $options->getY1(), 0, 0, $this->getWidth(), $this->getHeight(), $this->getWidth(), $this->getHeight());
        return $this->image->getResource();
    }
}
