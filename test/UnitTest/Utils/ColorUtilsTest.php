<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 03/11/17
 * Time: 20.34
 */

namespace Jackal\ImageMerge\Test\UnitTest\Utils;

use Jackal\ImageMerge\Utils\ColorUtils;
use PHPUnit\Framework\TestCase;

class ColorUtilsTest extends TestCase
{
    public function testParseHex()
    {
        $res = ColorUtils::parseHex('ABCDEF');
        $this->assertEquals(171,$res[0]);
        $this->assertEquals(205,$res[1]);
        $this->assertEquals(239,$res[2]);
    }
}
