<?php

namespace Jackal\ImageMerge\Model\Text;

use Exception;
use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\Model\Font\Font;

/**
 * Class Text
 * @package Jackal\ImageMerge\Model\Text
 */
class Text
{
    /**
     * Text constructor.
     * @param $text
     * @param $size
     * @param $color
     * @param string $text
     * @param int $size
     */
    public function __construct(private $text, private readonly Font $font, private $size, private readonly Color $color)
    {
    }

    /**
     * @throws Exception
     */
    public function fitToBox($boxWidth = null, $boxHeight = null): static
    {
        if (is_null($boxWidth) && is_null($boxHeight)) {
            throw new Exception('At least one dimension must be defined');
        }

        $finalSize = 1;
        for ($i = 1;$i <= 1000;$i += 0.5) {
            $textbox = imageftbbox(round($this->fontToPixel($i)), 0, (string) $this->getFont(), $this->getText());

            $height = $textbox[1] + abs($textbox[7]);
            $width = abs($textbox[2]) + $textbox[0];
            if (($height < $boxHeight || is_null($boxHeight)) && ($width < $boxWidth || is_null($boxWidth))) {
                continue;
            }
            $finalSize = $i;

            break;
        }
        $this->size = $finalSize;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->getBoundBox()['width'];
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->getBoundBox()['height'];
    }

    private function getBoundBox(): array
    {
        $textbox = imageftbbox($this->fontToPixel($this->size), 0, (string) $this->getFont(), $this->getText());

        return [
            'width' => abs($textbox[2]) + $textbox[0],
            'height' => $textbox[1] + abs($textbox[7]),
        ];
    }

    /**
     * @param $size
     */
    private function fontToPixel($size): float
    {
        return round($size * 0.75);
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    public function getFont(): Font
    {
        return $this->font;
    }

    /**
     * @return integer
     */
    public function getFontSize()
    {
        return $this->size;
    }

    public function getColor(): Color
    {
        return $this->color;
    }
}
