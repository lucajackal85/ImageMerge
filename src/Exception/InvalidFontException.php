<?php

namespace Jackal\ImageMerge\Exception;

/**
 * Class InvalidFontException
 * @package Jackal\ImageMerge\Exception
 */
class InvalidFontException extends \Exception
{
    /**
     * InvalidFontException constructor.
     * @param string $fontPath
     */
    public function __construct($fontPath)
    {
        parent::__construct($fontPath.' is not a valid font pathname');
    }

}