<?php

namespace Jackal\ImageMerge\Command\Options;

/**
 * Interface CommandOptionInterface
 * @package Jackal\ImageMerge\Command\Options
 */
interface CommandOptionInterface
{
    /**
     * @param $key
     * @return mixed
     */
    public function get($key);

    /**
     * @return array
     */
    public function all();
}
