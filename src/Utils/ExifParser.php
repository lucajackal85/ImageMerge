<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 19/11/17
 * Time: 15:17
 */

namespace Jackal\ImageMerge\Utils;


use Jackal\ImageMerge\Model\File\File;

class ExifParser
{
    public static function parse(File $file){
        $data = exif_read_data($file->getPathname());
        $data['make'] = $data['Make'];
        $data['model'] = $data['Model'];
        $data['exposure'] = $data['ExposureTime'];
        $data['flash'] = $data['Flash'] == true;
        $data['iso'] = $data['ISOSpeedRatings'];

        $length = $data['FocalLength'];
        if(strpos($length,'/1') !== false) {
            $data['focal_length'] = (int)str_replace('/1', '', $length);
        }else{
            $data['focal_length'] = $length;
        }

        return $data;
    }
}