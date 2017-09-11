<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 12.17
 */

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Utils\ColorUtils;

class BorderCommandOption extends AbstractCommandOption
{
    public function __construct($stroke, $color)
    {
        $this->add('stroke', $stroke);
        $this->add('color', $color);
    }

    public function getColors()
    {
        return $this->get('color');
    }

    public function getStroke()
    {
        return $this->get('stroke');
    }
}
