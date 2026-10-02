<?php

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\ValueObject\Dimension;

/**
 * Class DimensionCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
class DimensionCommandOption extends AbstractCommandOption
{
    /**
     * DimensionCommandOption constructor.
     */
    public function __construct(Dimension $dimension)
    {
        $this->add('dimension', $dimension);
    }

    /**
     * @return Dimension
     */
    public function getDimension()
    {
        return $this->get('dimension');
    }
}
