<?php

namespace Jackal\ImageMerge\Model\File;

use RuntimeException;

final class Filename
{
    /**
     * Atomically creates an empty, unpredictably named temp file readable only by the owner.
     */
    public static function createTempFilename(): string
    {
        $path = tempnam(sys_get_temp_dir(), 'imgmerge_');
        if ($path === false) {
            throw new RuntimeException('Unable to create a temporary file');
        }

        return $path;
    }
}
