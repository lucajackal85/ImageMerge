<?php

namespace Jackal\ImageMerge\Command\Asset;

use Exception;
use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\Options\SingleCoordinateFileObjectCommandOption;
use Jackal\ImageMerge\Model\Format\ImageReader;
use Jackal\ImageMerge\Model\Image;

/**
 * Class ImageAsset
 * @package Jackal\ImageMerge\Model\Asset
 */
class ImageAssetCommand extends AbstractCommand
{
    /**
     * ImageAssetCommand constructor.
     * @param SingleCoordinateFileObjectCommandOption $options
     */
    public function __construct(SingleCoordinateFileObjectCommandOption $options)
    {
        parent::__construct($options);
    }

    /**
     * @return resource
     * @throws Exception
     */
    protected function getResourceToApply()
    {
        $res = ImageReader::fromPathname($this->options->getFile());

        return $res->getResource();
    }

    /**
     * @return int
     * @throws Exception
     */
    protected function getWidth()
    {
        return imagesx($this->getResourceToApply());
    }

    /**
     * @return int
     * @throws Exception
     */
    protected function getHeight()
    {
        return imagesy($this->getResourceToApply());
    }

    /**
     * @param Image $image
     * @return Image
     * @throws Exception
     */
    public function execute(Image $image)
    {
        /** @var SingleCoordinateFileObjectCommandOption $options */
        $options = $this->options;
        imagecolortransparent($image->getResource());
        imagecopyresampled($image->getResource(), $this->getResourceToApply(), $options->getCoordinate1()->getX(), $options->getCoordinate1()->getY(), 0, 0, $this->getWidth(), $this->getHeight(), $this->getWidth(), $this->getHeight());
        $image->assignResource($image->getResource());

        return $image;
    }
}
