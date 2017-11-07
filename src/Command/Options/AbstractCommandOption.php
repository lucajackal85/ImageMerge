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
        if (!array_key_exists($key,$this->options)) {
            throw new \InvalidArgumentException(
                sprintf('Key %s is not valid, available options are: %s',
                    $key,
                    implode(',', array_keys($this->options)
                    )
                )
            );
        }
        return $this->options[$key];
    }

    public function all()
    {
        return $this->options;
    }
}
