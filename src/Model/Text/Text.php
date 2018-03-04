<?php

namespace Jackal\ImageMerge\Model\Text;

use Jackal\ImageMerge\Model\Font\Font;

/**
 * Class Text
 * @package Jackal\ImageMerge\Model\Text
 */
class Text
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var Font
     */
    private $font;

    /**
     * @var int
     */
    private $size;

    /**
     * @var string
     */
    private $color;

    /**
     * Text constructor.
     * @param $text
     * @param Font $font
     * @param $size
     * @param $color
     */
    public function __construct($text, Font $font, $size, $color)
    {
        $this->text = $text;
        $this->font = $font;
        $this->size = $size;
        $this->color = $color;
    }

    /**
     * @param null $boxWidth
     * @param null $boxHeight
     * @return Text
     * @throws \Exception
     */
    public function fitToBox($boxWidth = null, $boxHeight = null)
    {
        if (is_null($boxWidth) and is_null($boxHeight)) {
            throw new \Exception('At least one dimension must be defined');
        }

        $finalSize = 1;
        for ($i=1;$i<=1000;$i=$i+0.5) {
            $textbox = imageftbbox(round($this->fontToPixel($i)), 0, (string)$this->getFont(), $this->getText());

            $height = $textbox[1] + abs($textbox[7]);
            $width = abs($textbox[2]) + $textbox[0];
            if ((($height < $boxHeight) or is_null($boxHeight)) and (($width < $boxWidth) or is_null($boxWidth))) {
                continue;
            }
            $finalSize = $i;
            break;
        }
        $this->size = $finalSize;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->getBoundBox()['width'];
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->getBoundBox()['height'];
    }

    /**
     * @return array
     */
    private function getBoundBox()
    {
        $textbox = imageftbbox($this->fontToPixel($this->size), 0, (string)$this->getFont(), $this->getText());
        return [
            'width' => abs($textbox[2]) + $textbox[0],
            'height' => $textbox[1] + abs($textbox[7])
        ];
    }

    /**
     * @param $size
     * @return float
     */
    private function fontToPixel($size)
    {
        return round($size * 0.75);
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
