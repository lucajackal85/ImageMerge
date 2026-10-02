<?php

namespace Jackal\ImageMerge\Metadata;

use Jackal\ImageMerge\Exception\ModuleNotFoundException;
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
    private readonly ExifParser $exif;

    private readonly XMPParser $xmp;

    private readonly IPTCParser $iptc;

    /**
     * Metadata constructor.
     * @throws ModuleNotFoundException
     */
    public function __construct(FileObjectInterface $file)
    {
        $this->exif = new ExifParser($file);
        $this->xmp = new XMPParser($file);
        $this->iptc = new IPTCParser($file);
    }

    public function getExif(): ExifParser
    {
        return $this->exif;
    }

    public function getXMP(): XMPParser
    {
        return $this->xmp;
    }

    public function getIPTC(): IPTCParser
    {
        return $this->iptc;
    }
}
