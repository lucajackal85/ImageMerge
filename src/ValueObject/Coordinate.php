<?php

namespace Jackal\ImageMerge\ValueObject;

/**
 * Class Coordinate
 * @package Jackal\ImageMerge\Model
 */
class Coordinate
{
    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * Coordinate constructor.
     * @param $x
     * @param $y
     */
    public function __construct($x, $y)
    {
        $this->x = round($x);
        $this->y = round($y);
    }

    /**
     * @return integer
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return integer
     */
    public function getY()
    {
        return $this->y;
    }

    public function toArray()
    {
        return [
            $this->getX(),
            $this->getY(),
        ];
    }

    public function __toString()
    {
        return $this->getX() . 'X' . $this->getY();
    }

    public function match(Coordinate $coordinate)
    {
        return ($this->getX() == $coordinate->getX()) and ($this->getY() == $coordinate->getY());
    }
}
