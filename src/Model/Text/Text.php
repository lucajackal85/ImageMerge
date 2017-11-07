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

    private $color;

    public function __construct($text, Font $font, $size,$color)
    {
        $this->text = $text;
        $this->font = $font;
        $this->size = $size;
        $this->color = $color;
    }

    /**
     * @param $boxWidth
     * @param $boxHeight
     * @return $this
     */
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
        return $this;
    }

    public function getWidth(){
        return $this->getBoundBox()['width'];
    }

    public function getHeight(){
        return $this->getBoundBox()['height'];
    }

    /**
     * @return array
     */
    private function getBoundBox(){
        $textbox = imageftbbox($this->size * 0.75, 0, (string)$this->getFont(), $this->getText());
        return [
            'width' => abs($textbox[2]),
            'height' => abs($textbox[7])
        ];
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

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }
}
