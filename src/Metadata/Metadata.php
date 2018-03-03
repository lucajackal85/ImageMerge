<?php

namespace Jackal\ImageMerge\Metadata;

use Jackal\ImageMerge\Metadata\Parser\ExifParser;
use Jackal\ImageMerge\Metadata\Parser\IPTCParser;
use Jackal\ImageMerge\Metadata\Parser\XMPParser;
use Jackal\ImageMerge\Model\File\FileObjectInterface;

/**
 * Class Metadata
 * @package Jackal\ImageMerge\Metadata
 */
class Metadata
{
    /**
     * @var ExifParser
     */
    private $exif;

    /**
     * @var XMPParser
     */
    private $xmp;

    /**
     * @var IPTCParser
     */
    private $iptc;

    /**
     * Metadata constructor.
     * @param FileObjectInterface $file
     */
    public function __construct(FileObjectInterface $file)
    {
        $this->exif = new ExifParser($file);
        $this->xmp = new XMPParser($file);
        $this->iptc = new IPTCParser($file);
    }

    /**
     * @return ExifParser
     */
    public function getExif(){
        return $this->exif;
    }

    /**
     * @return XMPParser
     */
    public function getXMP(){
        return $this->xmp;
    }

    /**
     * @return IPTCParser
     */
    public function getIPTC(){
        return $this->iptc;
    }
}
