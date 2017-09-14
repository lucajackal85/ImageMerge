<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 12/09/17
 * Time: 9.30
 */

namespace Jackal\ImageMerge\Command\Options;

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
            $points[] = $arg->getX1();
            $points[] = $arg->getY1();
        }

        return $points;
    }

    public function countPoints()
    {
        return count($this->args);
    }

    public function getMinX()
    {
        return min($this->getEvenValues());
    }

    public function getMinY()
    {
        return min($this->getOddValues());
    }

    public function getMaxX()
    {
        return max($this->getEvenValues());
    }

    public function getMaxY()
    {
        return max($this->getOddValues());
    }

    public function getCropWidth()
    {
        return $this->getMaxX() - $this->getMinX();
    }

    public function getCropHeight()
    {
        return $this->getMaxY() - $this->getMinY();
    }
}
