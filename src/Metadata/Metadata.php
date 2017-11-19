<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 10/11/17
 * Time: 9.15
 */

namespace Jackal\ImageMerge\Metadata;

use Jackal\ImageMerge\Model\File\File;
use Jackal\ImageMerge\Utils\ExifParser;
use Jackal\ImageMerge\Utils\XMPParser;

class Metadata
{
    private $exif;
    private $xmp;

    public function __construct(File $file)
    {
        $this->exif = ExifParser::parse($file);
        $this->xmp = XMPParser::parse($file);
    }

    public function getExif(){
        return $this->exif;
    }

    public function getXMP(){
        return $this->xmp;
    }


}
