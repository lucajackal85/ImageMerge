<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 18.09
 */

namespace Jackal\ImageMerge\Command\Options;

abstract class AbstractCommandOption implements CommandOptionInterface
{
    protected $options = [];

    public function add($key, $value)
    {
        $this->options[$key] = $value;
    }

    public function get($key)
    {
        if (!isset($this->options[$key])) {
            return null;
        }
        return $this->options[$key];
    }

    public function all()
    {
        return $this->options;
    }
}
