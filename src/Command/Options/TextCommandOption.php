<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 11.26
 */

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Font\Font;

class TextCommandOption extends SingleCoordinateColorCommandOption
{
    public function __construct($text, Font $font, $fontSize, $x1, $y1, $colorHex ='000000')
    {
        parent::__construct($x1, $y1,$colorHex);
        $this->add('font', $font);
        $this->add('text', $text);
        $this->add('font_size', $fontSize);
    }

    public function getText()
    {
        return $this->get('text');
    }

    /**
     * @return Font
     */
    public function getFont()
    {
        return $this->get('font');
    }

    public function getFontSize()
    {
        return $this->get('font_size');
    }
}
