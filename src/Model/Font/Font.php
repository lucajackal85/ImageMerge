<?php

namespace Jackal\ImageMerge\Model\Font;

use Jackal\ImageMerge\Exception\InvalidFontException;

/**
 * Class Font
 * @package Jackal\ImageMerge\Model\Font
 */
class Font implements \Stringable
{
    public const FONT_LIBERATION_SANS = 'liberation_sans';

    /**
     * @deprecated since 1.0, use FONT_LIBERATION_SANS
     */
    public const FONT_ARIAL = self::FONT_LIBERATION_SANS;

    /**
     * @var string
     */
    private $fontPathname;

    private static function getFonts(): array
    {
        $directory = __DIR__ . '/../../Resources/Fonts/';

        return [
            // SIL Open Font License 1.1, see Resources/Fonts/LICENSE-LiberationSans.txt
            self::FONT_LIBERATION_SANS => $directory . 'LiberationSans-Regular.ttf',
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
     * Liberation Sans: a free font with the same metrics as Arial.
     *
     * @throws InvalidFontException
     */
    public static function liberationSans(): self
    {
        return new self(self::getFonts()[self::FONT_LIBERATION_SANS]);
    }

    /**
     * Arial itself cannot be redistributed; this returns Liberation Sans,
     * which has the same metrics, so existing layouts keep working.
     *
     * @deprecated since 1.0, use liberationSans()
     * @throws InvalidFontException
     */
    public static function arial(): self
    {
        return self::liberationSans();
    }

    public function __toString(): string
    {
        return $this->fontPathname;
    }
}
