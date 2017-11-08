<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 18.24
 */

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Coordinate;

class DoubleCoordinateCommandOption extends SingleCoordinateCommandOption
{
    protected $x2;

    protected $y2;

    public function __construct(Coordinate $coord1, Coordinate $coord2)
    {
        parent::__construct($coord1);
        $this->add('coord2', $coord2);
    }

    /**
     * @return mixed
     */
    public function getCoordinate2()
    {
        return $this->get('coord2');
    }
}
