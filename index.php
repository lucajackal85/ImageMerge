<?php

namespace Jackal\ImageMerge;

use Jackal\ImageMerge\Builder\ImageBuilder;
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
use Jackal\ImageMerge\Model\Coordinate;
use Jackal\ImageMerge\Model\File\File;
use Jackal\ImageMerge\Model\Font\Font;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\Model\Text\Text;
use SplFileObject;

require_once __DIR__.'/vendor/autoload.php';
if (!$_GET['raw']) {
    header('content-type: image/png');
}



//$image = new Image(500,500);
$builder = ImageBuilder::fromFile(new File(__DIR__.'/test/FunctionalTest/Resources/0.jpg'));

//$text = new Text('po',Font::arial(),30,'FFFFFF');
//$text->fitToBox(100,100);

    //->crop(0,0,500,500)
    //->addText($text,0,$text->getHeight())
    //->thumbnail(200)
    //->pixelate(20)
    //->blur(10)
    //->resize(100,100)
    //->grayScale()

//$builder->addCommand(EffectBlurCentered::class,new DimensionCommandOption(1920,1080));

var_dump($builder->getImage()->getMetadata()->all());
