<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 12.19
 */

namespace Jackal\ImageMerge\Utils;

class ColorUtils
{
    /**
     * @param $colorHex
     * @param null $part
     * @return array
     */
    public static function parseHex($colorHex)
    {
        return [
            hexdec(substr($colorHex, 0, 2)),
            hexdec(substr($colorHex, 2, 2)),
            hexdec(substr($colorHex, 4, 2)),
        ];
    }
}
