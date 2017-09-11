<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 30/08/17
 * Time: 16.43
 */

namespace Jackal\ImageMerge\Command\Asset;

use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\Options\TextCommandOption;

class TextAsset extends AbstractCommand
{
    public function execute()
    {
        /** @var TextCommandOption $options */
        $options = $this->options;

        $color = imagecolorallocate($this->image->getResource(),
            $options->getColorRed(),
            $options->getColorGreen(),
            $options->getColorBlue()
        );

        imagettftext($this->image->getResource(), $options->getFontSize(), 0, $options->getX1(), $options->getY1(), $color, $options->getFont(), $options->getText());
        return $this->image->getResource();
    }
}
