<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 08/11/17
 * Time: 12.34
 */

namespace Jackal\ImageMerge\Model;

class Color
{
    private $red;
    private $green;
    private $blue;

    public function __construct($colorHex)
    {
        $this->red = hexdec(substr($colorHex, 0, 2));
        $this->green = hexdec(substr($colorHex, 2, 2));
        $this->blue = hexdec(substr($colorHex, 4, 2));
    }

    public function red()
    {
        return $this->red;
    }

    public function green()
    {
        return $this->green;
    }

    public function blue()
    {
        return $this->blue;
    }
}
