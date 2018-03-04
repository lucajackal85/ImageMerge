<?php

namespace Jackal\ImageMerge\Command\Options;

/**
 * Class AbstractCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
abstract class AbstractCommandOption implements CommandOptionInterface
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @param $key
     * @param $value
     */
    public function add($key, $value)
    {
        $this->options[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        if (!array_key_exists($key, $this->options)) {
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

    /**
     * @return array
     */
    public function all()
    {
        return $this->options;
    }
}
