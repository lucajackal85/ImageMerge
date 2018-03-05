<?php

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\ValueObject\Dimention;

/**
 * Class DimensionCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
class DimensionCommandOption extends AbstractCommandOption
{
    /**
     * DimensionCommandOption constructor.
     * @param Dimention $dimention
     */
    public function __construct(Dimention $dimention)
    {
        $this->add('dimention', $dimention);
    }

    /**
     * @return Dimention
     */
    public function getDimention()
    {
        return $this->get('dimention');
    }
}
