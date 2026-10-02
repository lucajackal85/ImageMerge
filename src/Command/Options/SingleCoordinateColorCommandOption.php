<?php

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\ValueObject\Coordinate;

/**
 * Class SingleCoordinateColorCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
class SingleCoordinateColorCommandOption extends SingleCoordinateCommandOption
{
    /**
     * SingleCoordinateColorCommandOption constructor.
     */
    public function __construct(Coordinate $coordinate, Color $color)
    {
        parent::__construct($coordinate);
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
