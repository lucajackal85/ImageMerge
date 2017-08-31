<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 30/08/17
 * Time: 12.52
 */

namespace Jackal\ImageMerge\Model\Format;


class ImageFormat
{
    const PNG = 'png';
    const JPG = 'jpg';
    const GIF = 'gif';

    public static function getFormats(){
        return [
            ImageFormat::PNG,
            ImageFormat::JPG,
            ImageFormat::GIF
        ];
    }
}