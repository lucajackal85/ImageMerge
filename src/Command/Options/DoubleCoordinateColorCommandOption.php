<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 9.34
 */

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Utils\ColorUtils;

class DoubleCoordinateColorCommandOption extends DoubleCoordinateCommandOption
{
    public function __construct($x1, $y1, $x2, $y2, $colorHex = '000000')
    {
        parent::__construct($x1, $y1, $x2, $y2);
        $this->add('colors', ColorUtils::parseHex($colorHex));
    }

    public function getColorRed()
    {
        return $this->get('colors')[0];
    }

    public function getColorGreen()
    {
        return $this->get('colors')[1];
    }

    public function getColorBlue()
    {
        return $this->get('colors')[2];
    }
}
