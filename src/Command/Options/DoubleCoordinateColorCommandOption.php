<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 9.34
 */

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\Utils\ColorUtils;

class DoubleCoordinateColorCommandOption extends DoubleCoordinateCommandOption
{
    public function __construct($x1, $y1, $x2, $y2, $colorHex = '000000')
    {
        parent::__construct($x1, $y1, $x2, $y2);
        $this->add('color', new Color($colorHex));
    }

    public function getColor(){
        return $this->get('color');
    }


}
