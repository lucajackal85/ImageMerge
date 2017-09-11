<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 11.33
 */

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Utils\ColorUtils;

class SingleCoordinateColorCommandOption extends SingleCoordinateCommandOption
{
    public function __construct($x1, $y1, $colorHex)
    {
        parent::__construct($x1, $y1);
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
