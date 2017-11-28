<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 28/11/17
 * Time: 23:08
 */

namespace Jackal\ImageMerge\Test\UnitTest\Model\ImageContent;


use Jackal\ImageMerge\Model\ImageContent\ImageGIFContent;
use PHPUnit\Framework\TestCase;

class ImageGIFContentTest extends TestCase
{
    public function testContent(){

        $content = new ImageGIFContent('this is the content');

        $this->assertEquals('this is the content',(string)$content);
        $this->assertEquals('this is the content',$content->getContent());
        $this->assertEquals('image/gif',$content->getContentType());
    }
}