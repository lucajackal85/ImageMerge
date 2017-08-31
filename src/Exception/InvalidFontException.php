<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 31/08/17
 * Time: 15.04
 */

namespace Edimotive\ImageMerge\Exception;


use Throwable;

class InvalidFontException extends \Exception
{
    public function __construct($fontPath)
    {
        parent::__construct($fontPath.' is not a valid font pathname');
    }

}