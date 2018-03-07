<?php

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\ValueObject\Coordinate;
use Jackal\ImageMerge\ValueObject\Dimention;

/**
 * Class MultiCoordinateCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
class MultiCoordinateCommandOption extends AbstractCommandOption
{
    /**
     * @var Coordinate[]
     */
    private $args;

    /**
     * MultiCoordinateCommandOption constructor.
     * @param SingleCoordinateCommandOption[] $coords
     */
    public function __construct(array $coords)
    {
        $this->args = $coords;
    }

    private function getOddValues()
    {
        $arr = [];
        foreach ($this->toArray() as $k => $point) {
            if ($k % 2 == 1) {
                $arr[] = $point;
            }
        }
        return $arr;
    }

    private function getEvenValues()
    {
        $arr = [];
        foreach ($this->toArray() as $k => $point) {
            if ($k == 0 or ($k % 2 == 0)) {
                $arr[] = $point;
            }
        }
        return $arr;
    }

    /**
     * @return Coordinate[]
     */
    public function getCoordinates()
    {
        $coords = [];
        $points = $this->toArray();
        foreach ($points as $k => $coordinateCommandOption) {
            if ($k == 0) {
                $coords[] = new Coordinate($coordinateCommandOption, $points[$k+1]);
            } else {
                if (($k % 2) == 0) {
                    $coords[] = new Coordinate($coordinateCommandOption, $points[$k+1]);
                }
            }
        }

        return $coords;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $points = [];
        /** @var Coordinate $arg */
        foreach ($this->args as $arg) {
            $points[] = $arg->getX();
            $points[] = $arg->getY();
        }

        return $points;
    }

    /**
     * @return int
     */
    public function countPoints()
    {
        return count($this->args);
    }

    /**
     * @return mixed
     */
    public function getMinX()
    {
        return min($this->getEvenValues());
    }

    /**
     * @return mixed
     */
    public function getMinY()
    {
        return min($this->getOddValues());
    }

    /**
     * @return mixed
     */
    public function getMaxX()
    {
        return max($this->getEvenValues());
    }

    /**
     * @return mixed
     */
    public function getMaxY()
    {
        return max($this->getOddValues());
    }

    /**
     * @return Dimention
     */
    public function getCropDimention()
    {
        return new Dimention($this->getMaxX() - $this->getMinX(), $this->getMaxY() - $this->getMinY());
    }


    public function isQuadrilateral()
    {
        return $this->countPoints() == 4;
    }
}
