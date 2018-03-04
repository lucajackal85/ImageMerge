<?php

namespace Jackal\ImageMerge\Test\FunctionalTest;

use Jackal\ImageMerge\Model\Image;
use PHPUnit\Framework\TestCase;

abstract class FunctionalTest extends TestCase
{
    protected function assertPNGSameImage(Image $image, $imagePathnameToCompare)
    {
        $this->assertEquals(file_get_contents($imagePathnameToCompare), $image->toPNG()->getContent());
    }

    protected function assertJPGSameImage(Image $image, $imagePathnameToCompare)
    {
        $this->assertEquals(file_get_contents($imagePathnameToCompare), $image->toJPG()->getContent());
    }
}
