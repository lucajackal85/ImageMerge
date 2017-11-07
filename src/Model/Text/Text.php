<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 07/11/17
 * Time: 10.34
 */

namespace Jackal\ImageMerge\Model\Text;

use Jackal\ImageMerge\Model\Font\Font;

class Text
{
    private $text;

    private $font;

    private $size;

    public function __construct($text, Font $font, $size)
    {
        $this->text = $text;
        $this->font = $font;
        $this->size = $size;
    }

    public function fitToBox($boxWidth, $boxHeight)
    {
        $finalSize = 1;
        for ($i=1;$i<=100;$i++) {
            $textbox = imageftbbox($i * 0.75, 0, (string)$this->getFont(), $this->getText());
            if($textbox[1] < $boxHeight and $textbox[2] < $boxWidth){
                continue;
            }
            $finalSize = $i;
            break;
        }
        $this->size = $finalSize;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return Font
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * @return integer
     */
    public function getFontSize()
    {
        return $this->size;
    }
}
