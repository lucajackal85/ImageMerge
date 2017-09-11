<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 18.24
 */

namespace Jackal\ImageMerge\Command\Options;

class DoubleCoordinateCommandOption extends SingleCoordinateCommandOption
{
    protected $x2;

    protected $y2;

    public function __construct($x1, $y1, $x2, $y2)
    {
        parent::__construct($x1, $y1);
        $this->add('x2', $x2);
        $this->add('y2', $y2);
    }

    /**
     * @return mixed
     */
    public function getX2()
    {
        return $this->get('x2');
    }

    /**
     * @return mixed
     */
    public function getY2()
    {
        return $this->get('y2');
    }
}
