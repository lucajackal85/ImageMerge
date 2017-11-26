<?php

namespace Jackal\ImageMerge\Model;

/**
 * Class Color
 * @package Jackal\ImageMerge\Model
 */
class Color
{
    /**
     * @var string
     */
    private $red;

    /**
     * @var string
     */
    private $green;

    /**
     * @var string
     */
    private $blue;

    /**
     * Color constructor.
     * @param $colorHex
     */
    public function __construct($colorHex)
    {
        $this->red = hexdec(substr($colorHex, 0, 2));
        $this->green = hexdec(substr($colorHex, 2, 2));
        $this->blue = hexdec(substr($colorHex, 4, 2));
    }

    /**
     * @return string
     */
    public function red()
    {
        return $this->red;
    }

    /**
     * @return string
     */
    public function green()
    {
        return $this->green;
    }

    /**
     * @return string
     */
    public function blue()
    {
        return $this->blue;
    }
}
