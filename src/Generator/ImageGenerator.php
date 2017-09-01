<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 30/08/17
 * Time: 13.40
 */

namespace Jackal\ImageMerge\Generator;

use Jackal\ImageMerge\Exception\InvalidFormatException;
use Jackal\ImageMerge\Exception\UnsupportedConfigurationException;
use Jackal\ImageMerge\Model\Asset\AssetInterface;
use Jackal\ImageMerge\Model\Configuration\ImageConfiguration;
use Jackal\ImageMerge\Model\Format\ImageFormat;
use Jackal\ImageMerge\Model\Format\ImageReader;
use Jackal\ImageMerge\Model\Format\ImageWriter;

class ImageGenerator
{
    protected $format;
    /**
     * @var ImageConfiguration
     */
    protected $imageConfiguration;

    /**
     * ImageGenerator constructor.
     * @param $format
     * @param ImageConfiguration $imageConfiguration
     * @throws InvalidFormatException
     */
    public function __construct($format, ImageConfiguration $imageConfiguration)
    {
        if (!in_array($format, ImageFormat::getFormats())) {
            throw new InvalidFormatException($format);
        }

        $this->format = $format;
        $this->imageConfiguration = $imageConfiguration;
    }

    /**
     * @return resource
     */
    protected function getResource()
    {
        if (!$this->imageConfiguration->getBackground()) {
            $baseResource = imagecreatetruecolor($this->imageConfiguration->getWidth(), $this->imageConfiguration->getHeight());
            imagecolortransparent($baseResource);
        } else {
            $resource = ImageReader::fromPathname($this->imageConfiguration->getBackground());
            $baseResource = $resource->getResource();
        }

        /** @var AssetInterface $asset */
        foreach ($this->imageConfiguration->getAssets() as $asset) {
            $asset->applyToResource($baseResource);
        }

        $this->applyBlur($baseResource,$this->imageConfiguration->getBlur());

        if ($this->imageConfiguration->getOutputWidth() != $this->imageConfiguration->getWidth() or $this->imageConfiguration->getOutputHeight() != $this->imageConfiguration->getHeight()) {
            $resourceResized = imagecreatetruecolor($this->imageConfiguration->getOutputWidth(), $this->imageConfiguration->getOutputHeight());
            imagecolortransparent($resourceResized);
            imagecopyresampled($resourceResized, $baseResource, 0, 0, 0, 0, $this->imageConfiguration->getOutputWidth(), $this->imageConfiguration->getOutputHeight(), $this->imageConfiguration->getWidth(), $this->imageConfiguration->getHeight());
            $baseResource = $resourceResized;
        }

        $baseResource = $this->applyRotate($baseResource,$this->imageConfiguration->getDegree());

        return $baseResource;
    }

    private function applyBlur($resource,$blur){
        if($blur) {
            for ($i = 0; $i < $this->imageConfiguration->getBlur(); $i++) {
                imagefilter($resource, IMG_FILTER_GAUSSIAN_BLUR);
            }
        }
    }

    private function applyRotate($resource,$degree){
        return imagerotate($resource,$degree,0);
    }

    public function getOutput()
    {
        switch (true) {
            case $this->format == ImageFormat::PNG:{
                return ImageWriter::toPNG($this->getResource());
            }
            case $this->format == ImageFormat::JPG:{
                return ImageWriter::toJPG($this->getResource());
            }
            case $this->format == ImageFormat::GIF:{
                return ImageWriter::toGIF($this->getResource());
            }
            default:{
                throw new UnsupportedConfigurationException();
            }
        }
    }
}
