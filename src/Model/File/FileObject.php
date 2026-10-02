<?php

namespace Jackal\ImageMerge\Model\File;

use SplFileObject;

class FileObject extends SplFileObject implements FileObjectInterface
{
    public function getContents()
    {
        $this->rewind();
        $size = $this->getSize();

        return $size > 0 ? $this->fread($size) : '';
    }
}
