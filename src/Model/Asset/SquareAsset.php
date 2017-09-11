<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 11.59
 */

namespace Jackal\ImageMerge\Model\Asset;

use Jackal\ImageMerge\Utils\ColorUtils;

class SquareAsset implements AssetInterface
{
    private $width;
    private $colorHex;
    private $x1;
    private $y1;
    private $x2;
    private $y2;

    public function __construct($width, $x1, $y1, $x2, $y2, $colorHex = '000000')
    {
        $this->width = $width;
        $this->colorHex = $colorHex;
        $this->x1 = $x1;
        $this->y1 = $y1;
        $this->x2 = $x2;
        $this->y2 = $y2;
    }

    public function applyToResource($resource)
    {
        $color = imagecolorallocate($resource, ColorUtils::parseHex($this->colorHex)[0], ColorUtils::parseHex($this->colorHex)[1], ColorUtils::parseHex($this->colorHex)[2]);
        imagefilledrectangle($resource, $this->x1, $this->y1, $this->x2, $this->y2, $color);
    }
}
