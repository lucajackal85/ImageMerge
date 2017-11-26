<?php

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Coordinate;

/**
 * Class DoubleCoordinateCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
class DoubleCoordinateCommandOption extends SingleCoordinateCommandOption
{
    /**
     * @var integer
     */
    protected $x2;

    /**
     * @var integer
     */
    protected $y2;

    /**
     * DoubleCoordinateCommandOption constructor.
     * @param Coordinate $coord1
     * @param Coordinate $coord2
     */
    public function __construct(Coordinate $coord1, Coordinate $coord2)
    {
        parent::__construct($coord1);
        $this->add('coord2', $coord2);
    }

    /**
     * @return mixed
     */
    public function getCoordinate2()
    {
        return $this->get('coord2');
    }
}
