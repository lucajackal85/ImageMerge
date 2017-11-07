<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 07/11/17
 * Time: 17.57
 */

namespace Jackal\ImageMerge\Test\Options;


use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use PHPUnit\Framework\TestCase;

class DimensionCommandOptionTest extends TestCase
{
    public function testDimensionCommandOption(){

        $object = new DimensionCommandOption(10,20);

        $this->assertEquals(10,$object->getWidth());
        $this->assertEquals(20,$object->getHeight());
    }
}