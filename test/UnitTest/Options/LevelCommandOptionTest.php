<?php

namespace Jackal\ImageMerge\Test\Options;

use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use PHPUnit\Framework\TestCase;

class LevelCommandOptionTest extends TestCase
{
    public function testLevelCommandOptionObject()
    {
        $object = new LevelCommandOption(20);
        $this->assertEquals(20, $object->getLevel());
    }

    public function testRaiseExceptionOnInvalidGetter()
    {
        $this->setExpectedException('\InvalidArgumentException', 'Key INVALID-KEY is not valid, available options are: level');
        $object = new LevelCommandOption(10);

        $object->get('INVALID-KEY');
    }

    public function testNotRaiseExceptionOnNullGetter()
    {
        $object = new LevelCommandOption(null);

        $this->assertNull($object->get('level'));
    }
}
