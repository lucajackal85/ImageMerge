<?php

namespace Jackal\ImageMerge\Metadata\Parser;

use Jackal\ImageMerge\Model\File\FileInterface;

/**
 * Interface ParserInterface
 * @package Jackal\ImageMerge\Metadata\Parser
 */
interface ParserInterface
{
    /**
     * ParserInterface constructor.
     * @param FileInterface $file
     */
    public function __construct(FileInterface $file);

    /**
     * @return array
     */
    public function toArray();
}