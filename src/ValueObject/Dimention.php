<?php


namespace Jackal\ImageMerge\ValueObject;

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
        if (!$width and !$height) {
            throw new \InvalidArgumentException('Both width and height are empy values');
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
