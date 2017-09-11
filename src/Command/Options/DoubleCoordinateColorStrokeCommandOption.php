<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 11.12
 */

namespace Jackal\ImageMerge\Command\Options;

class DoubleCoordinateColorStrokeCommandOption extends DoubleCoordinateColorCommandOption
{
    public function __construct($x1, $y1, $x2, $y2, $stroke = 1, $colorHex = '000000')
    {
        parent::__construct($x1, $y1, $x2, $y2, $colorHex);
        $this->add('stroke', $stroke);
    }

    public function getStroke()
    {
        return $this->get('stroke');
    }
}
