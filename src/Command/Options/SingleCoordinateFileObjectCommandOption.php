<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 10.57
 */

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Coordinate;
use Jackal\ImageMerge\Model\File\File;
use Jackal\ImageMerge\Model\File\FileInterface;

class SingleCoordinateFileObjectCommandOption extends SingleCoordinateCommandOption
{
    public function __construct(FileInterface $imageObject, Coordinate $coordinate)
    {
        parent::__construct($coordinate);
        $this->add('file_object', $imageObject);
    }

    public function getFile()
    {
        return $this->get('file_object');
    }
}
