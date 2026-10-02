<?php

namespace Jackal\ImageMerge\ValueObject;

use InvalidArgumentException;

class Dimension
{
    private readonly ?int $width;

    private readonly ?int $height;

    /**
     * Dimension constructor.
     * @param $width
     * @param $height
     */
    public function __construct(?int $width, ?int $height)
    {
        if (!$width) {
            $width = null;
        }

        if (!$height) {
            $height = null;
        }

        if (is_null($width) && is_null($height)) {
            throw new InvalidArgumentException('Both width and height are empty values');
        }

        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }
}
