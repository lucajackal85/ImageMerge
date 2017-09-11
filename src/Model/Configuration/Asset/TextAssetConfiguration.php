<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 30/08/17
 * Time: 17.25
 */

namespace Jackal\ImageMerge\Model\Configuration\Asset;

use Jackal\ImageMerge\Utils\ColorUtils;

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
        return ColorUtils::parseHex($this->fontColorRGB)[0];
    }

    public function getFontColorGreen()
    {
        return ColorUtils::parseHex($this->fontColorRGB)[1];
    }

    public function getFontColorBlue()
    {
        return ColorUtils::parseHex($this->fontColorRGB)[2];
    }
}
