<?php

namespace Jackal\ImageMerge\Model\File;

final class Filename
{
    public static function createTempFilename()
    {
        return sys_get_temp_dir().'/'.uniqid('tmp_');
    }
}
