<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 07/11/17
 * Time: 17.18
 */

namespace Jackal\ImageMerge\Test\Options;


use Jackal\ImageMerge\Command\Options\TextCommandOption;
use Jackal\ImageMerge\Model\Font\Font;
use Jackal\ImageMerge\Model\Text\Text;
use PHPUnit\Framework\TestCase;

class TextCommandOptionsTest extends TestCase
{
    public function testTextCommandOptionsObject(){

        $text = new Text('this is a text',Font::arial(),12,'ABCDEF');

        $object = new TextCommandOption($text,10,20);

        $this->assertEquals(10,$object->getX1());
        $this->assertEquals(20,$object->getY1());

        $this->assertEquals(239,$object->getColor()->blue());
        $this->assertEquals(205,$object->getColor()->Green());
        $this->assertEquals(171,$object->getColor()->red());

    }
}