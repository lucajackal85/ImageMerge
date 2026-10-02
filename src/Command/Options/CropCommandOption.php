<?php

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\ValueObject\Coordinate;
use Jackal\ImageMerge\ValueObject\Dimension;

/**
 * Class CropCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
class CropCommandOption extends DimensionCommandOption
{
    /**
     * CropCommandOption constructor.
     */
    public function __construct(Coordinate $coordinate, Dimension $dimension)
    {
        parent::__construct($dimension);
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
