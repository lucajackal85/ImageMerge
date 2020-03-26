<?php

require_once __DIR__ . '/../vendor/autoload.php';

$output = new Symfony\Component\Console\Output\ConsoleOutput();

function error(){
    global $output;
    $output->write('<bg=red>E</>');
}

function warning(){
    global $output;
    $output->write('<fg=yellow>W</>');
}

function success(){
    global $output;
    $output->write('.');
}

function checkPHPExt($name){
    if(!extension_loaded($name)){
        error();
    }else{
        success();
    }
}

function checkPHPFunction($functionName){
    if(!function_exists($functionName)){
        warning();
    }else{
        success();
    }
}

version_compare(PHP_VERSION, '5.5.11', '<') ? error() : success();
checkPHPExt('gd');
checkPHPExt('exif');

$gdInfo = gd_info();
$gdInfo['GIF Create Support'] ? success() : warning();
$gdInfo['GIF Read Support'] ? success() : warning();
$gdInfo['PNG Support'] ? success() : warning();
$gdInfo['JPEG Support'] ? success() : warning();
$gdInfo['WebP Support'] ? success() : warning();

checkPHPFunction('exif_read_data');
checkPHPFunction('iptcembed');
checkPHPFunction('imagettftext');

try{
    \Jackal\ImageMerge\Utils\ImageMagickUtils::getImageMagickBin();
    success();
}catch (RuntimeException $e){
    warning();
}

$output->writeln('');