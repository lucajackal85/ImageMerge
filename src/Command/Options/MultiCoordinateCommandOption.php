<?php

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\ValueObject\Coordinate;
use Jackal\ImageMerge\ValueObject\Dimension;

/**
 * Class MultiCoordinateCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
class MultiCoordinateCommandOption extends AbstractCommandOption
{
    /**
     * MultiCoordinateCommandOption constructor.
     * @param Coordinate[] $args
     */
    public function __construct(private readonly array $args)
    {
    }

    /**
     * @return mixed[]
     */
    private function getOddValues(): array
    {
        $arr = [];
        foreach ($this->toArray() as $k => $point) {
            if ($k % 2 === 1) {
                $arr[] = $point;
            }
        }

        return $arr;
    }

    /**
     * @return mixed[]
     */
    private function getEvenValues(): array
    {
        $arr = [];
        foreach ($this->toArray() as $k => $point) {
            if ($k == 0 || $k % 2 === 0) {
                $arr[] = $point;
            }
        }

        return $arr;
    }

    /**
     * @return Coordinate[]
     */
    public function getCoordinates(): array
    {
        $coords = [];
        $points = $this->toArray();
        foreach ($points as $k => $coordinateCommandOption) {
            if ($k == 0) {
                $coords[] = new Coordinate($coordinateCommandOption, $points[$k + 1]);
            } else {
                if ($k % 2 === 0) {
                    $coords[] = new Coordinate($coordinateCommandOption, $points[$k + 1]);
                }
            }
        }

        return $coords;
    }

    public function toArray(): array
    {
        $points = [];
        /** @var Coordinate $arg */
        foreach ($this->args as $arg) {
            $points[] = $arg->getX();
            $points[] = $arg->getY();
        }

        return $points;
    }

    public function countPoints(): int
    {
        return count($this->args);
    }

    public function getMinX(): mixed
    {
        return min($this->getEvenValues());
    }

    public function getMinY(): mixed
    {
        return min($this->getOddValues());
    }

    public function getMaxX(): mixed
    {
        return max($this->getEvenValues());
    }

    public function getMaxY(): mixed
    {
        return max($this->getOddValues());
    }

    public function getCropDimension(): Dimension
    {
        return new Dimension($this->getMaxX() - $this->getMinX(), $this->getMaxY() - $this->getMinY());
    }

    public function isQuadrilateral(): bool
    {
        return $this->countPoints() === 4;
    }
}
