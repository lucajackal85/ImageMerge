<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 18.21
 */

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Coordinate;

class SingleCoordinateCommandOption extends AbstractCommandOption
{
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
