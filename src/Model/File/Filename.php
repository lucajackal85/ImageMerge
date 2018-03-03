<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 03/03/18
 * Time: 15.14
 */

namespace Jackal\ImageMerge\Model\File;


final class Filename
{
    public static function createTempFilename(){
        return sys_get_temp_dir().'/'.uniqid('tmp_');
    }
}