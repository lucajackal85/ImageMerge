<?php

namespace Jackal\ImageMerge\Command\Options;

/**
 * Class BorderCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
class BorderCommandOption extends AbstractCommandOption
{
    /**
     * BorderCommandOption constructor.
     * @param $stroke
     * @param $color
     */
    public function __construct($stroke, $color)
    {
        $this->add('stroke', $stroke);
        $this->add('color', $color);
    }

    /**
     * @return mixed
     */
    public function getColors()
    {
        return $this->get('color');
    }

    /**
     * @return mixed
     */
    public function getStroke()
    {
        return $this->get('stroke');
    }
}
