<?php

namespace Jackal\ImageMerge\Metadata\Parser;

/**
 * Class AbstractParser
 * @package Jackal\ImageMerge\Metadata\Parser
 */
abstract class AbstractParser implements ParserInterface
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return !$this->data;
    }

    /**
     * @param $key
     * @return string|null|array
     */
    protected function getValue($key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        return null;
    }

    /**
     * @param $key
     * @return int|string
     */
    protected function getDivisionValue($key)
    {
        $value = $this->getValue($key);
        if (!is_string($value) || !preg_match('#^(-?\d+)/(\d+)$#', $value, $matches)) {
            return $value;
        }

        if ((int) $matches[2] === 0) {
            return null;
        }

        $result = (int) $matches[1] / (int) $matches[2];

        return floor($result) == $result ? (int) $result : $result;

    }

    /**
     * @param $key
     * @return bool|null
     */
    protected function getBooleanValue($key)
    {
        $value = $this->getSingleValue($key);
        if (is_null($value)) {
            return $value;
        }

        return $value == true and strtolower($value) != 'false';
    }

    /**
     * @param $data
     * @return string|null
     */
    protected function removeEmptyData($data)
    {
        if (is_string($data) and $data == '') {
            return null;
        }

        return $data;
    }

    /**
     * @param $key
     * @return string|null
     */
    protected function getSingleValue($key)
    {
        $value = $this->getValue($key);
        if (is_array($value)) {
            $value = array_shift($value);
        }
        if (is_null($value)) {
            return null;
        }

        return preg_replace('/\r\n|\r/', "\n", (string) $value);
    }
}
