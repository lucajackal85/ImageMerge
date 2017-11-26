<?php

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Coordinate;

/**
 * Class SingleCoordinateCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
class SingleCoordinateCommandOption extends AbstractCommandOption
{
    /**
     * SingleCoordinateCommandOption constructor.
     * @param Coordinate $coordinate
     */
    public function __construct(Coordinate $coordinate)
    {
        $this->add('coord1', $coordinate);
    }

    /**
     * @return Coordinate
     */
    public function getCoordinate1()
    {
        return $this->get('coord1');
    }
}
