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
     * @param ImageConfiguration $imageConfiguration
     * @throws InvalidFormatException
     */
    public function __construct(ImageConfiguration $imageConfiguration)
    {
        $format = $imageConfiguration->getFormat();
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

        foreach ($this->imageConfiguration->getOperationOrder() as $order) {
            switch ($order) {
                case ImageConfiguration::OP_RESIZE:{
                    $baseResource = $this->applyResize($baseResource);
                    break;
                }
                case ImageConfiguration::OP_ROTATE:{
                    $baseResource = $this->applyRotate($baseResource, $this->imageConfiguration->getDegree());
                    break;
                }
                case ImageConfiguration::OP_BLUR:{
                    $this->applyBlur($baseResource, $this->imageConfiguration->getBlur());
                    break;
                }
                case ImageConfiguration::OP_ASSETS:{
                    /** @var AssetInterface $asset */
                    foreach ($this->imageConfiguration->getAssets() as $asset) {
                        $asset->applyToResource($baseResource);
                    }
                    break;
                }
                default: throw new \Exception('Operation "'.$order.'" not managed');
            }
        }






        return $baseResource;
    }
    
    private function applyResize($resource)
    {
        if ($this->imageConfiguration->getOutputWidth() != $this->imageConfiguration->getWidth() or $this->imageConfiguration->getOutputHeight() != $this->imageConfiguration->getHeight()) {
            $resourceResized = imagecreatetruecolor($this->imageConfiguration->getOutputWidth(), $this->imageConfiguration->getOutputHeight());
            imagecolortransparent($resourceResized);
            imagecopyresampled($resourceResized, $resource, 0, 0, 0, 0, $this->imageConfiguration->getOutputWidth(), $this->imageConfiguration->getOutputHeight(), $this->imageConfiguration->getWidth(), $this->imageConfiguration->getHeight());
            return $resourceResized;
        }
        return $resource;
    }

    private function applyBlur($resource, $blur)
    {
        if ($blur) {
            for ($i = 0; $i < $this->imageConfiguration->getBlur(); $i++) {
                imagefilter($resource, IMG_FILTER_GAUSSIAN_BLUR);
            }
        }
    }

    private function applyRotate($resource, $degree)
    {
        if ($degree and ($degree % 360)) {
            return imagerotate($resource, $degree, 0);
        }
        return $resource;
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
