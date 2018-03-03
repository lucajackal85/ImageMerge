<?php

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Coordinate;
use Jackal\ImageMerge\Model\File\FileObjectInterface;

/**
 * Class SingleCoordinateFileObjectCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
class SingleCoordinateFileObjectCommandOption extends SingleCoordinateCommandOption
{
    /**
     * SingleCoordinateFileObjectCommandOption constructor.
     * @param FileObjectInterface $imageObject
     * @param Coordinate $coordinate
     */
    public function __construct(FileObjectInterface $imageObject, Coordinate $coordinate)
    {
        parent::__construct($coordinate);
        $this->add('file_object', $imageObject);
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->get('file_object');
    }
}
