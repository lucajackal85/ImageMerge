<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 30/08/17
 * Time: 16.43
 */

namespace Edimotive\ImageMerge\Model\Asset;

use Edimotive\ImageMerge\Model\Configuration\Asset\TextAssetConfiguration;

class TextAsset implements AssetInterface
{
    /**
     * @var string
     */
    protected $text;

    /**
     * @var TextAssetConfiguration
     */
    protected $configuration;

    /**
     * @var int
     */
    protected $x;

    /**
     * @var int
     */
    protected $y;

    /**
     * TextAsset constructor.
     * @param $text
     * @param TextAssetConfiguration $configuration
     * @param $x
     * @param $y
     */
    public function __construct($text, TextAssetConfiguration $configuration, $x = null, $y = null)
    {
        $this->text = $text;
        $this->configuration = $configuration;
        $this->x = (int)$x;
        $this->y = (int)(is_null($y) ? $this->configuration->getFontSize() : $y);
    }

    /**
     * @param $resource
     * @return mixed
     */
    public function applyToResource($resource)
    {
        $color = imagecolorallocate($resource,
            $this->configuration->getFontColorRed(),
            $this->configuration->getFontColorGreen(),
            $this->configuration->getFontColorBlue()
        );

        imagettftext($resource, $this->configuration->getFontSize(), 0, $this->x, $this->y, $color, $this->configuration->getFontFilename(), $this->text);
        return $resource;
    }
}
