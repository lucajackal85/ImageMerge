<?php

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\Model\Coordinate;

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
     * @param string $colorHex
     * @throws \Jackal\ImageMerge\Exception\InvalidColorException
     */
    public function __construct(Coordinate $coordinate1, Coordinate $coordinate2, $colorHex = Color::BLACK)
    {
        parent::__construct($coordinate1, $coordinate2);
        $this->add('color', new Color($colorHex));
    }

    /**
     * @return mixed
     */
    public function getColor(){
        return $this->get('color');
    }


}
