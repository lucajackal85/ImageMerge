<?php

namespace Jackal\ImageMerge\Test\FunctionalTest;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Command\Effect\Distortion;
use Jackal\ImageMerge\Command\Options\MultiCoordinateCommandOption;
use Jackal\ImageMerge\ImageMerge;
use Jackal\ImageMerge\ValueObject\Coordinate;
use Jackal\ImageMerge\Model\File\FileObject;

class DistortionTest extends FunctionalTest
{
    public function testDistortion()
    {
        $imageMerge = new ImageMerge();
        $builder = $imageMerge->getBuilder(new FileObject(__DIR__.'/Resources/DistortionTest/01.jpg'));


        $builder->addCommand(new Distortion($builder->getImage(), new MultiCoordinateCommandOption([
            new Coordinate(26, 0),
            new Coordinate(114, 23),
            new Coordinate(128, 100),
            new Coordinate(0, 123),
        ])));

        $this->assertJPGSameImage($builder->getImage(), __DIR__.'/Resources/DistortionTest/02.jpg');
    }
}
