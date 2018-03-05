<?php

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\ValueObject\Coordinate;
use Jackal\ImageMerge\ValueObject\Dimention;

/**
 * Class CropCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
class CropCommandOption extends DimensionCommandOption
{
    /**
     * CropCommandOption constructor.
     * @param Coordinate $coordinate
     * @param Dimention $dimention
     */
    public function __construct(Coordinate $coordinate, Dimention $dimention)
    {
        parent::__construct($dimention);
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
