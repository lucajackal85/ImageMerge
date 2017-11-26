<?php

namespace Jackal\ImageMerge\Command\Options;

/**
 * Class DimensionCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
class DimensionCommandOption extends AbstractCommandOption
{
    /**
     * DimensionCommandOption constructor.
     * @param $width
     * @param $height
     */
    public function __construct($width, $height)
    {
        $this->add('width', $width);
        $this->add('height', $height);
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->get('width');
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->get('height');
    }
}
