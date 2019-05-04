<?php


namespace Jackal\ImageMerge\ValueObject;

use InvalidArgumentException;

class Dimention
{
    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * Dimention constructor.
     * @param $width
     * @param $height
     */
    public function __construct($width, $height)
    {
        if (!$width) {
            $width = null;
        }

        if (!$height) {
            $height = null;
        }

        if (is_null($width) and is_null($height)) {
            throw new InvalidArgumentException('Both width and height are empty values');
        }

        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }
}
