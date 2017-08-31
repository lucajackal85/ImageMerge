<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 31/08/17
 * Time: 13.58
 */

namespace Edimotive\ImageMerge\Test;


use Edimotive\ImageMerge\Model\Asset\ImageAsset;
use Edimotive\ImageMerge\Model\Configuration\Asset\ImageAssetConfiguration;
use PHPUnit\Framework\TestCase;

class ImageAssetTest extends TestCase
{
    public function testConstruct(){

        $imageAssetConfigurationMock = $this->getMockBuilder(ImageAssetConfiguration::class)->getMock();

        $ia = new ImageAsset($imageAssetConfigurationMock,10,20);
    }
}