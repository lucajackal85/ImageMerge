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

    protected function add($key, $value)
    {
        $this->options[$key] = $value;
    }

    public function get($key)
    {
        if (!isset($this->options[$key])) {
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
