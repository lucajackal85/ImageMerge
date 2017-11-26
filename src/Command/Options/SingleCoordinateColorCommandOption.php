<?php

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\Model\Coordinate;

/**
 * Class SingleCoordinateColorCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
class SingleCoordinateColorCommandOption extends SingleCoordinateCommandOption
{
    /**
     * SingleCoordinateColorCommandOption constructor.
     * @param Coordinate $coordinate
     * @param $colorHex
     */
    public function __construct(Coordinate $coordinate, $colorHex)
    {
        parent::__construct($coordinate);
        $this->add('color', new Color($colorHex));
    }

    /**
     * @return mixed
     */
    public function getColor(){
        return $this->get('color');
    }
}
