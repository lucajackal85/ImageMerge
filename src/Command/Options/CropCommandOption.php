<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 17.12
 */

namespace Jackal\ImageMerge\Command\Options;

class CropCommandOption extends DimensionCommandOption
{
    public function __construct($x1, $y1, $width, $height)
    {
        parent::__construct($width, $height);
        $this->add('x1', $x1);
        $this->add('y1', $y1);
    }

    public function getX1()
    {
        return $this->get('x1');
    }

    public function getY1()
    {
        return $this->get('y1');
    }
}
