<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 30/08/17
 * Time: 17.25
 */

namespace Edimotive\ImageMerge\Model\Configuration\Asset;

class TextAssetConfiguration
{
    protected $x;
    protected $y;
    protected $fontFilename;
    protected $fontSize;
    protected $fontColorRGB;

    public static function create($fontFilename, $fontSize, $fontColorRGB = 000000)
    {
        $tc = new self();
        $tc->fontFilename =  $fontFilename;
        $tc->fontSize = $fontSize;
        $tc->fontColorRGB = $fontColorRGB;

        return $tc;
    }

    public function getFontFilename()
    {
        return $this->fontFilename;
    }

    public function getFontSize()
    {
        return $this->fontSize;
    }

    public function getFontColorRed()
    {
        return hexdec(substr($this->fontColorRGB, 0, 2));
    }

    public function getFontColorGreen()
    {
        return hexdec(substr($this->fontColorRGB, 2, 2));
    }

    public function getFontColorBlue()
    {
        return hexdec(substr($this->fontColorRGB, 4, 2));
    }
}
