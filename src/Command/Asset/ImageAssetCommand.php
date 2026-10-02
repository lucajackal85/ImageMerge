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
    private ?\GdImage $resource = null;

    /**
     * ImageAssetCommand constructor.
     */
    public function __construct(SingleCoordinateFileObjectCommandOption $options)
    {
        parent::__construct($options);
    }

    /**
     * @return \GdImage
     * @throws Exception
     */
    protected function getResourceToApply(): ?\GdImage
    {
        return $this->resource ??= ImageReader::fromPathname($this->options->getFile())->getResource();
    }

    /**
     * @throws Exception
     */
    protected function getWidth(): int
    {
        return imagesx($this->getResourceToApply());
    }

    /**
     * @throws Exception
     */
    protected function getHeight(): int
    {
        return imagesy($this->getResourceToApply());
    }

    /**
     * @throws Exception
     */
    public function execute(Image $image): Image
    {
        /** @var SingleCoordinateFileObjectCommandOption $options */
        $options = $this->options;
        imagecolortransparent($image->getResource());
        imagecopyresampled($image->getResource(), $this->getResourceToApply(), $options->getCoordinate1()->getX(), $options->getCoordinate1()->getY(), 0, 0, $this->getWidth(), $this->getHeight(), $this->getWidth(), $this->getHeight());
        $image->assignResource($image->getResource());

        return $image;
    }
}
