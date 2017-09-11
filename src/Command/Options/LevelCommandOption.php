<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 18.08
 */

namespace Jackal\ImageMerge\Command\Options;

class LevelCommandOption extends AbstractCommandOption
{
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
