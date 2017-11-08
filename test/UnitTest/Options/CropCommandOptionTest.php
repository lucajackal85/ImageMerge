<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 07/11/17
 * Time: 17.58
 */

namespace Jackal\ImageMerge\Test\Options;


use Jackal\ImageMerge\Command\Options\CropCommandOption;
use Jackal\ImageMerge\Model\Coordinate;
use PHPUnit\Framework\TestCase;

class CropCommandOptionTest extends TestCase
{
    public function testCropCommandOption(){

        $object = new CropCommandOption(new Coordinate(10,20),100,120);

        $this->assertEquals(10,$object->getCoordinate1()->getX());
        $this->assertEquals(20,$object->getCoordinate1()->getY());

        $this->assertEquals(100,$object->getWidth());
        $this->assertEquals(120,$object->getHeight());


    }
}