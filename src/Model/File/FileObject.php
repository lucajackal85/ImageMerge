<?php

namespace Jackal\ImageMerge\Model\File;

use \SplFileObject;

class FileObject extends SplFileObject implements FileObjectInterface
{
    public function getContents()
    {
        $this->seek(0);

        return $this->fread($this->getSize());
    }
}
