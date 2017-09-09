<?php

namespace Jackal\ImageMerge;

use Jackal\ImageMerge\Effect\EffectBlurCentered;
use Jackal\ImageMerge\Effect\EffectBorder;
use Jackal\ImageMerge\Model\Asset\ImageAsset;
use Jackal\ImageMerge\Model\Asset\LineAsset;
use Jackal\ImageMerge\Model\Asset\TextAsset;
use Jackal\ImageMerge\Model\Configuration\Asset\TextAssetConfiguration;
use Jackal\ImageMerge\Model\Configuration\ImageConfiguration;
use Jackal\ImageMerge\Model\Font\Font;
use Jackal\ImageMerge\Model\Image;
use SplFileObject;

require_once __DIR__.'/vendor/autoload.php';

$textConfiguration = TextAssetConfiguration::create(Font::arial(), 20, 'FFCCFF');

//$configuration->addAsset(new ImageAsset('/var/www/asset1.png',50,60));
//$configuration->addAsset(new ImageAsset('/var/www/asset2.gif'));
//$configuration->addAsset(new ImageAsset('/var/www/asset3.png'));
//$configuration->addAsset(new TextAsset('Questa è una prova', $textConfiguration));
//$image = new Image(1000,200);

$image = Image::fromFile(new SplFileObject('/var/www/208.jpg'));

if (!$_GET['raw']) {
    header('content-type: image/png');
}

//$image->addEffect(new EffectBorder(1,'CCCCCC'));
$image->addEffect(new EffectBlurCentered(1280, 720));

echo $image->toPNG();
