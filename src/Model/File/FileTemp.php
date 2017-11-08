<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 08/11/17
 * Time: 11.38
 */

namespace Jackal\ImageMerge\Model\File;


class FileTemp extends File
{
    public static function fromString($content)
    {
        $path = sys_get_temp_dir().'/'.uniqid('tmp_');

        $o = new self($path, 'w+');
        $o->fwrite($content);
        $o->seek(0);

        return $o;
    }

    public function __destruct(){
        if(is_file($this->getPathname())) {
            unlink($this->getPathname());
        }
    }
}