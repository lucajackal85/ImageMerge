<?php

namespace Jackal\ImageMerge\Model\File;

interface FileObjectInterface
{
    public function getPathname();

    public function getContents();
}
