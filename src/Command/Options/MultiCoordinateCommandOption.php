<?php

namespace Jackal\ImageMerge\Command\Options;

/**
 * Class MultiCoordinateCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
class MultiCoordinateCommandOption extends AbstractCommandOption
{
    /**
     * @var SingleCoordinateCommandOption[]
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
        foreach ($this->getCoordinates() as $k => $point) {
            if ($k % 2 == 1) {
                $arr[] = $point;
            }
        }
        return $arr;
    }

    private function getEvenValues()
    {
        $arr = [];
        foreach ($this->getCoordinates() as $k => $point) {
            if ($k == 0 or ($k % 2 == 0)) {
                $arr[] = $point;
            }
        }
        return $arr;
    }

    /**
     * @return array
     */
    public function getCoordinates()
    {
        $points = [];
        /** @var SingleCoordinateCommandOption $arg */
        foreach ($this->args as $arg) {
            $points[] = $arg->getCoordinate1()->getX();
            $points[] = $arg->getCoordinate1()->getY();
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
     * @return mixed
     */
    public function getCropWidth()
    {
        return $this->getMaxX() - $this->getMinX();
    }

    /**
     * @return mixed
     */
    public function getCropHeight()
    {
        return $this->getMaxY() - $this->getMinY();
    }

    public function isQuadrilateral(){
        return count($this->getCoordinates()) == 8;
    }

}
