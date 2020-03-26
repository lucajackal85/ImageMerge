<?php

namespace Jackal\ImageMerge\Model\Font;

use Jackal\ImageMerge\Exception\InvalidFontException;

/**
 * Class Font
 * @package Jackal\ImageMerge\Model\Font
 */
class Font
{
    const FONT_ARIAL = 'arial';

    /**
     * @var string
     */
    private $fontPathname;

    /**
     * @return array
     */
    private static function getFonts()
    {
        $directory = dirname(__FILE__) . '/../../Resources/Fonts/';

        return [
            self::FONT_ARIAL => $directory . 'arial.ttf',
        ];
    }

    /**
     * Font constructor.
     * @param $fontPathname
     * @throws InvalidFontException
     */
    public function __construct($fontPathname)
    {
        if (!is_file($fontPathname)) {
            throw new InvalidFontException('Font file not found at path ' . $fontPathname);
        }
        $this->fontPathname = $fontPathname;
    }

    /**
     * @return Font
     * @throws InvalidFontException
     */
    public static function arial()
    {
        $fonts = Font::getFonts();

        return new Font($fonts[Font::FONT_ARIAL]);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->fontPathname;
    }
}
