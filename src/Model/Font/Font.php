<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 31/08/17
 * Time: 14.59
 */

namespace Jackal\ImageMerge\Model\Font;

use Jackal\ImageMerge\Exception\InvalidFontException;

class Font
{
    const FONT_ARIAL = 'arial';

    private $fontName;

    private function getFonts()
    {
        $directory = dirname(__FILE__).'/../../Resources/Fonts/';
        return [
            self::FONT_ARIAL => $directory.'arial.ttf'
        ];
    }

    public function __construct($fontName)
    {
        $this->fontName = $fontName;
        $fonts = $this->getFonts();

        if (!isset($fonts[$this->fontName])) {
            throw new InvalidFontException($this->fontName);
        }

        if(!is_file($fonts[$this->fontName])){
            throw new InvalidFontException($fonts[$this->fontName]);
        }
    }

    public function __toString()
    {
        return $this->getFonts()[$this->fontName];
    }
}
