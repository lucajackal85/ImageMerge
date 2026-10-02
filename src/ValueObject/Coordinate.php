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
    private int $x;

    /**
     * @var int
     */
    private int $y;

    /**
     * Coordinate constructor.
     * @param $x
     * @param $y
     */
    public function __construct(int|float $x, int|float $y)
    {
        $this->x = (int) round($x);
        $this->y = (int) round($y);
    }

    /**
     * @return integer
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return integer
     */
    public function getY(): int
    {
        return $this->y;
    }

    public function toArray(): array
    {
        return [
            $this->getX(),
            $this->getY(),
        ];
    }

    public function __toString(): string
    {
        return $this->getX() . 'X' . $this->getY();
    }

    public function match(Coordinate $coordinate): bool
    {
        return ($this->getX() == $coordinate->getX()) and ($this->getY() == $coordinate->getY());
    }
}
