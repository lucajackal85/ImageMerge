<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 07/11/17
 * Time: 21.25
 */

namespace Jackal\ImageMerge\Model\File;

class FileObject extends \SplFileObject implements FileObjectInterface
{

    public function getContents()
    {
        $this->seek(0);
        return $this->fread($this->getSize());
    }
}
