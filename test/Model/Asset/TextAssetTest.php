<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 31/08/17
 * Time: 12.56
 */

namespace Edimotive\ImageMerge\Test;


use Edimotive\ImageMerge\Model\Asset\TextAsset;
use Edimotive\ImageMerge\Model\Configuration\Asset\TextAssetConfiguration;
use PHPUnit\Framework\TestCase;

class TextAssetTest extends TestCase
{
    public function testConstruct(){

        $textAssetConfigurationMock = $this->getMockBuilder(TextAssetConfiguration::class)->getMock();

        $ta = new TextAsset('this is a text',$textAssetConfigurationMock);
    }
}