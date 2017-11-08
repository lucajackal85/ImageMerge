<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 07/11/17
 * Time: 22.18
 */

namespace Jackal\ImageMerge\Model;

class Coordinate
{
    private $x;
    private $y;

    public function __construct($x,$y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return integer
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return integer
     */
    public function getY()
    {
        return $this->y;
    }


}
