<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 30/08/17
 * Time: 12.56
 */

namespace Edimotive\ImageMerge\Exception;


class InvalidFormatException extends \Exception
{
    public function __construct($format)
    {
        parent::__construct('"'.$format.'" is not a valid image format');
    }

}