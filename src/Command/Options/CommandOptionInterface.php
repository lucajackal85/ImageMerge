<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 18.04
 */

namespace Jackal\ImageMerge\Command\Options;

interface CommandOptionInterface
{
    public function add($key, $value);

    public function get($key);

    public function all();
}
