<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 08/11/17
 * Time: 11.53
 */

namespace Jackal\ImageMerge\Test\UnitTest\Model\File;


use Jackal\ImageMerge\Model\File\FileTemp;
use PHPUnit\Framework\TestCase;

class FileTempTest extends TestCase
{
    public function testRemoveFileOnDestruct(){

        $tempFilepath = __DIR__.'/temp.file';

        fopen($tempFilepath,'w');

        $file = new FileTemp($tempFilepath);

        $this->assertTrue(file_exists($tempFilepath));

        //destruct
        $file = null;

        $this->assertFalse(file_exists($tempFilepath));
    }

    public function testCreateFromString(){

        $tf = FileTemp::fromString('this is the string');

        $this->assertEquals('this is the string',$tf->getContents());
        $this->assertTrue(file_exists($tf->getPathname()));
    }
}