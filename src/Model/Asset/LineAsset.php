<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 0.15
 */

namespace Jackal\ImageMerge\Model\Asset;

class LineAsset implements AssetInterface
{
    private $x1;
    private $y1;
    private $x2;
    private $y2;
    private $colorHex;

    public function __construct($x1, $y1, $x2, $y2,$colorHex = '000000')
    {
        $this->x1 = $x1;
        $this->y1 = $y1;
        $this->x2 = $x2;
        $this->y2 = $y2;
        $this->colorHex = $colorHex;
    }


    public function applyToResource($resource)
    {
        $black = imagecolorallocate($resource, hexdec(substr($this->colorHex,0,2)), hexdec(substr($this->colorHex,2,2)), hexdec(substr($this->colorHex,4,2)));
        imageline($resource, $this->x1, $this->y1, $this->x2, $this->y2, $black);
    }
}
