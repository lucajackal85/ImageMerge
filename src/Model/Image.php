<?php

namespace Jackal\ImageMerge\Model;

use Jackal\ImageMerge\Exception\UnsupportedConfigurationException;
use Jackal\ImageMerge\Generator\ImageGenerator;
use Jackal\ImageMerge\Model\Configuration\ImageConfiguration;
use Jackal\ImageMerge\Model\Format\ImageFormat;
use Jackal\ImageMerge\Model\Format\ImageReader;
use Jackal\ImageMerge\Model\Format\ImageWriter;

class Image
{
    /**
     * @var ImageConfiguration
     */
    protected $imageConfiguration;

    protected $assets = [];

    /**
     * Image constructor.
     * @param ImageConfiguration $imageConfiguration
     */
    public function __construct(ImageConfiguration $imageConfiguration)
    {
        $this->imageConfiguration = $imageConfiguration;
    }

    public function dump()
    {
        $generator = new ImageGenerator($this->imageConfiguration->getFormat(), $this->imageConfiguration);
        return $generator->getOutput();
    }

    public function resize($width, $height)
    {
        $this->imageConfiguration->changeOutputDimension($width, $height);
        return $this;
    }

    /**
     * @return $this
     */
    public function toPNG()
    {
        $this->imageConfiguration->changeFormat(ImageFormat::PNG);
        return $this;
    }

    /**
     * @return $this
     */
    public function toJPG()
    {
        $this->imageConfiguration->changeFormat(ImageFormat::JPG);
        return $this;
    }

    /**
     * @return $this
     */
    public function toGIF()
    {
        $this->imageConfiguration->changeFormat(ImageFormat::GIF);
        return $this;
    }
}
