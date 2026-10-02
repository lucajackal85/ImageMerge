<?php

namespace Jackal\ImageMerge\Model\File;

use SplFileObject;

class FileObject extends SplFileObject implements FileObjectInterface
{
    public function getContents()
    {
        $this->rewind();
        // fstat() reads the open handle; getSize() may return a stale cached size right after a write
        $size = $this->fstat()['size'];

        return $size > 0 ? $this->fread($size) : '';
    }
}
