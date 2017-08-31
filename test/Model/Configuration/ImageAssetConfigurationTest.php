<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 31/08/17
 * Time: 14.08
 */

namespace Jackal\ImageMerge\Test\Model\Configuration;

use Jackal\ImageMerge\Model\Configuration\Asset\ImageAssetConfiguration;
use PHPUnit\Framework\TestCase;

class ImageAssetConfigurationTest extends TestCase
{
    public function testConstruct()
    {
        $iac = ImageAssetConfiguration::fromFile('filename');

        $this->assertEquals('filename', $iac->getPathname());
    }
}
