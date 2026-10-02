<?php

namespace Jackal\ImageMerge\Metadata\Parser;

use Jackal\ImageMerge\Model\File\FileObjectInterface;

/**
 * Interface ParserInterface
 * @package Jackal\ImageMerge\Metadata\Parser
 */
interface ParserInterface
{
    /**
     * ParserInterface constructor.
     */
    public function __construct(FileObjectInterface $file);

    /**
     * @return array
     */
    public function toArray();
}
