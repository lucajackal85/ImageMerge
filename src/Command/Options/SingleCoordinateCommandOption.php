<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 18.21
 */

namespace Jackal\ImageMerge\Command\Options;

class SingleCoordinateCommandOption extends AbstractCommandOption
{
    public function __construct($x1, $y1)
    {
        $this->add('x1', $x1);
        $this->add('y1', $y1);
    }

    /**
     * @return int
     */
    public function getX1()
    {
        return $this->get('x1');
    }

    /**
     * @return int
     */
    public function getY1()
    {
        return $this->get('y1');
    }
}
