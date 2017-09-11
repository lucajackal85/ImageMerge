<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 19.17
 */

namespace Jackal\ImageMerge\Command\Options;

class DimensionCommandOption extends AbstractCommandOption
{
    public function __construct($width, $height)
    {
        $this->add('width', $width);
        $this->add('height', $height);
    }

    public function getWidth()
    {
        return $this->get('width');
    }

    public function getHeight()
    {
        return $this->get('height');
    }
}
