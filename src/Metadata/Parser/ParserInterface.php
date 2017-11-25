<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 25/11/17
 * Time: 00:28
 */

namespace Jackal\ImageMerge\Metadata\Parser;


use Jackal\ImageMerge\Model\File\File;

interface ParserInterface
{
    public function __construct(File $file);
}