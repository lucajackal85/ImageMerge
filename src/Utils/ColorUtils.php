<?php

namespace Jackal\ImageMerge\Utils;

use Jackal\ImageMerge\Model\Color;

/**
 * Class ColorUtils
 * @package Jackal\ImageMerge\Utils
 */
class ColorUtils
{
    /**
     * @param $resource
     * @param Color $color
     * @param bool $alpha
     * @return int
     */
    public static function colorIdentifier($resource, Color $color, $alpha = false)
    {
        if (!$alpha) {
            return imagecolorallocate($resource, $color->red(), $color->green(), $color->blue());
        } else {
            return imagecolorallocatealpha($resource, $color->red(), $color->green(), $color->blue(), 127);
        }
    }
}
