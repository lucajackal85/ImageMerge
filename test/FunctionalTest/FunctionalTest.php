<?php

namespace Jackal\ImageMerge\Test\FunctionalTest;

use BigV\ImageCompare;
use Jackal\ImageMerge\Model\File\FileTempObject;
use Jackal\ImageMerge\Model\Image;
use PHPUnit\Framework\TestCase;

abstract class FunctionalTest extends TestCase
{
    private $filesToRemove = [];

    protected function assertPNGSameImage(Image $image, $imagePathnameToCompare)
    {
        $expectedContent = file_get_contents($imagePathnameToCompare);
        $actualContent = $image->toPNG()->getContent();

        $uid = uniqid();
        $expectedContentFile = sys_get_temp_dir().'/'.$uid.'_expected.png';
        $actualContentFile = sys_get_temp_dir().'/'.$uid.'_actual.png';

        file_put_contents($expectedContentFile,$expectedContent);
        file_put_contents($actualContentFile,$actualContent);

        $ic = new ImageCompare();
        $result = $ic->compare($expectedContentFile,$actualContentFile);

        if($result != 0) {
            $this->fail('Images are different. saving to: ' . $expectedContentFile . ', ' . $actualContentFile);
        }
    }

    protected function assertJPGSameImage(Image $image, $imagePathnameToCompare)
    {
        $expectedContent = file_get_contents($imagePathnameToCompare);
        $actualContent = $image->toJPG()->getContent();

        $uid = uniqid();
        $expectedContentFile = sys_get_temp_dir().'/'.$uid.'_expected.jpg';
        $actualContentFile = sys_get_temp_dir().'/'.$uid.'_actual.jpg';

        file_put_contents($expectedContentFile,$expectedContent);
        file_put_contents($actualContentFile,$actualContent);

        $ic = new ImageCompare();
        $result = $ic->compare($expectedContentFile,$actualContentFile);

        if($result != 0) {
            $this->fail('Images are different. saving to: ' . $expectedContentFile . ', ' . $actualContentFile);
        }
    }
}
