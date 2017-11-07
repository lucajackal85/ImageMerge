<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 07/11/17
 * Time: 17.52
 */

namespace Jackal\ImageMerge\Test\Options;


use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use PHPUnit\Framework\TestCase;

class LevelCommandOptionTest extends TestCase
{
    public function testLevelCommandOptionObject(){

        $object = new LevelCommandOption(20);
        $this->assertEquals(20,$object->getLevel());
    }
}