<?php

namespace Jackal\ImageMerge\Model;

use Jackal\ImageMerge\Effect\EffectInterface;
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
        $generator = new ImageGenerator($this->imageConfiguration);
        return $generator->getOutput();
    }

    public function toFile($filePathname)
    {
        file_put_contents($filePathname, $this->dump());
    }

    public function resize($width, $height)
    {
        $this->imageConfiguration->changeOutputDimension($width, $height);
        return $this;
    }

    public function blur($level = 10)
    {
        $this->imageConfiguration->addBlur($level);
        return $this;
    }

    public function rotate($degree = 90)
    {
        $this->imageConfiguration->addDegree($degree);
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

    public function addEffect(EffectInterface $effect)
    {
        return $effect->execute($this,$this->imageConfiguration);
    }
}