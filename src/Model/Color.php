<?php

namespace Jackal\ImageMerge\Model;

use Jackal\ImageMerge\Exception\InvalidColorException;

/**
 * Class Color
 * @package Jackal\ImageMerge\Model
 */
class Color
{
    public const BLACK = '000000';
    public const WHITE = 'FFFFFF';

    private readonly int|float $red;

    private readonly int|float $green;

    private readonly int|float $blue;

    private readonly string $colorHex;

    /**
     * Color constructor.
     * @param $colorHex
     * @throws InvalidColorException
     */
    public function __construct($colorHex)
    {
        if (str_starts_with($colorHex, '#')) {
            $colorHex = substr($colorHex, 1);
        }

        preg_match('/[A-Fa-f0-9]{6}|[A-Fa-f0-9]{3}/', $colorHex, $matches);

        if (!$matches || strlen($colorHex) !== strlen($matches[0])) {
            throw new InvalidColorException(sprintf('Color "%s" is invalid', $colorHex));
        }

        $colorHex = $matches[0];

        if (strlen($colorHex) === 3) {
            $c1 = str_repeat(substr($colorHex, 0, 1), 2);
            $c2 = str_repeat(substr($colorHex, 1, 1), 2);
            $c3 = str_repeat(substr($colorHex, 2, 1), 2);
            $colorHex = $c1 . $c2 . $c3;
        }

        $this->colorHex = $colorHex;

        $this->red = hexdec(substr($colorHex, 0, 2));
        $this->green = hexdec(substr($colorHex, 2, 2));
        $this->blue = hexdec(substr($colorHex, 4, 2));
    }

    public function red(): int|float
    {
        return $this->red;
    }

    public function green(): int|float
    {
        return $this->green;
    }

    public function blue(): int|float
    {
        return $this->blue;
    }

    public function rgb(): string
    {
        return $this->red() . $this->green() . $this->blue();
    }

    public function getHex(): string
    {
        return $this->colorHex;
    }
}
