<?php

namespace Jackal\ImageMerge;

use Jackal\ImageMerge\Command\Asset\ImageAsset;
use Jackal\ImageMerge\Command\Asset\TextAsset;
use Jackal\ImageMerge\Command\AssetCommand;
use Jackal\ImageMerge\Command\Effect\EffectBlurCentered;
use Jackal\ImageMerge\Command\Options\AssetCommandOption;
use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Command\Options\SingleCoordinateCommandOption;
use Jackal\ImageMerge\Command\Options\SingleCoordinateFileObjectCommandOption;
use Jackal\ImageMerge\Factory\CommandFactory;
use Jackal\ImageMerge\Model\Font\Font;
use Jackal\ImageMerge\Model\Image;
use SplFileObject;

require_once __DIR__.'/vendor/autoload.php';
if (!$_GET['raw']) {
    header('content-type: image/png');
}

$image = Image::fromFile(new SplFileObject('/var/www/vertical.jpg'));
//$image = new Image(1920,1080);
$image->addText('questo è un testo',Font::arial(),12,20,20,'FFFFFF');

$image->merge(Image::fromFile(new \SplFileObject('insigna.jpg')),30,40);


echo $image->toPNG();
