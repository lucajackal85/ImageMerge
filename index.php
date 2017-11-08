<?php

namespace Jackal\ImageMerge;

use Jackal\ImageMerge\Command\Asset\ImageAssetCommand;
use Jackal\ImageMerge\Command\Asset\SquareAssetCommand;
use Jackal\ImageMerge\Command\Asset\TextAssetCommand;
use Jackal\ImageMerge\Command\AssetCommand;
use Jackal\ImageMerge\Command\Effect\EffectBlurCentered;
use Jackal\ImageMerge\Command\Options\AssetCommandOption;
use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Command\Options\DoubleCoordinateColorCommandOption;
use Jackal\ImageMerge\Command\Options\DoubleCoordinateColorStrokeCommandOption;
use Jackal\ImageMerge\Command\Options\SingleCoordinateCommandOption;
use Jackal\ImageMerge\Command\Options\SingleCoordinateFileObjectCommandOption;
use Jackal\ImageMerge\Factory\CommandFactory;
use Jackal\ImageMerge\Model\File\File;
use Jackal\ImageMerge\Model\Font\Font;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\Model\Text\Text;
use SplFileObject;

require_once __DIR__.'/vendor/autoload.php';
if (!$_GET['raw']) {
    header('content-type: image/png');
}

$image = Image::fromFile(new File(__DIR__.'/image1.jpg'));
//$image = new Image(500,500);

$text = new Text('po',Font::arial(),30,'FFFFFF');
//$text->fitToBox(100,100);

$image->addCommand(SquareAssetCommand::class,new DoubleCoordinateColorCommandOption(0,0,$text->getWidth(),$text->getHeight(),1,'FFFFFF'));


$image->addText($text,0,$text->getHeight());

$image->thumbnail(200);
$image->pixelate(20);
$image->blur(10);

$image->addCommand(EffectBlurCentered::class,new DimensionCommandOption(500,500));

echo $image->toPNG();
