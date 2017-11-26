<?php

namespace Jackal\ImageMerge\Command\Options;

/**
 * Class LevelCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
class LevelCommandOption extends AbstractCommandOption
{
    /**
     * LevelCommandOption constructor.
     * @param $level
     */
    public function __construct($level)
    {
        $this->add('level', $level);
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->get('level');
    }
}
