<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 17.12
 */

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Coordinate;

class CropCommandOption extends DimensionCommandOption
{
    public function __construct(Coordinate $coordinate, $width, $height)
    {
        parent::__construct($width, $height);
        $this->add('coord1', $coordinate);
    }

    public function getCoordinate1()
    {
        return $this->get('coord1');
    }
}
