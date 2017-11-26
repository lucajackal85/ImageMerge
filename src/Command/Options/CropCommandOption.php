<?php

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Coordinate;

/**
 * Class CropCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
class CropCommandOption extends DimensionCommandOption
{
    /**
     * CropCommandOption constructor.
     * @param Coordinate $coordinate
     * @param $width
     * @param $height
     */
    public function __construct(Coordinate $coordinate, $width, $height)
    {
        parent::__construct($width, $height);
        $this->add('coord1', $coordinate);
    }

    /**
     * @return mixed
     */
    public function getCoordinate1()
    {
        return $this->get('coord1');
    }
}
