<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 10/11/17
 * Time: 9.15
 */

namespace Jackal\ImageMerge\Metadata;

use Jackal\ImageMerge\Metadata\Parser\ExifParser;
use Jackal\ImageMerge\Metadata\Parser\IPTCParser;
use Jackal\ImageMerge\Metadata\Parser\XMPParser;
use Jackal\ImageMerge\Model\File\File;

class Metadata
{
    private $exif;
    private $xmp;
    private $iptc;

    public function __construct(File $file)
    {
        $this->exif = new ExifParser($file);
        $this->xmp = new XMPParser($file);
        $this->iptc = new IPTCParser($file);
    }

    public function getExif(){
        return $this->exif;
    }

    /**
     * @return XMPParser
     */
    public function getXMP(){
        return $this->xmp;
    }

    public function getIPTC(){
        return $this->iptc;
    }


}
