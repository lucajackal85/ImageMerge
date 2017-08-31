<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 31/08/17
 * Time: 14.24
 */

namespace Edimotive\ImageMerge\Test\Model;

use Edimotive\ImageMerge\Model\Format\ImageFormat;
use PHPUnit\Framework\TestCase;

class ImageFormatTest extends TestCase
{
    public function testFormatsDefinitions()
    {
        $this->assertEquals(['png','jpg','gif'], ImageFormat::getFormats());
    }
}
