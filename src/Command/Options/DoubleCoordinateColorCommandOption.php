<?php

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\ValueObject\Coordinate;

/**
 * Class DoubleCoordinateColorCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
class DoubleCoordinateColorCommandOption extends DoubleCoordinateCommandOption
{
    /**
     * DoubleCoordinateColorCommandOption constructor.
     * @param Coordinate $coordinate1
     * @param Coordinate $coordinate2
     * @param Color $color
     */
    public function __construct(Coordinate $coordinate1, Coordinate $coordinate2, Color $color)
    {
        parent::__construct($coordinate1, $coordinate2);
        $this->add('color', $color);
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->get('color');
    }
}
