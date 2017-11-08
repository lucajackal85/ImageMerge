<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 9.34
 */

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\Model\Coordinate;
use Jackal\ImageMerge\Utils\ColorUtils;

class DoubleCoordinateColorCommandOption extends DoubleCoordinateCommandOption
{
    public function __construct(Coordinate $coordinate1, Coordinate $coordinate2, $colorHex = '000000')
    {
        parent::__construct($coordinate1, $coordinate2);
        $this->add('color', new Color($colorHex));
    }

    public function getColor(){
        return $this->get('color');
    }


}
