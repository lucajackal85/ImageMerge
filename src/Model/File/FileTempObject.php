<?php

namespace Jackal\ImageMerge\Model\File;

class FileTempObject extends FileObject
{
    public static function fromString($content)
    {
        $path = Filename::createTempFilename();

        $o = new self($path, 'w+');
        $o->fwrite($content);
        $o->seek(0);

        return $o;
    }

    public function __destruct()
    {
        if (is_file($this->getPathname())) {
            unlink($this->getPathname());
        }
    }
}
