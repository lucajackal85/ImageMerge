<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 07/11/17
 * Time: 17.58
 */

namespace Jackal\ImageMerge\Test\Options;


use Jackal\ImageMerge\Command\Options\CropCommandOption;
use PHPUnit\Framework\TestCase;

class CropCommandOptionTest extends TestCase
{
    public function testCropCommandOption(){

        $object = new CropCommandOption(10,20,100,120);

        $this->assertEquals(10,$object->getX1());
        $this->assertEquals(20,$object->getY1());

        $this->assertEquals(100,$object->getWidth());
        $this->assertEquals(120,$object->getHeight());


    }
}