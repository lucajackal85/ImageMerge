<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 17.15
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\CropCommandOption;
use Jackal\ImageMerge\Model\Image;

class CropCommand extends AbstractCommand
{
    public function __construct(Image $image, CropCommandOption $options)
    {
        parent::__construct($image, $options);
    }

    /**
     * @return Image
     */
    public function execute()
    {
        /** @var CropCommandOption $options */
        $options = $this->options;
        $newImage = imagecrop($this->image->getResource(), [
            'x' => $options->getX1(),
            'y' => $options->getY1(),
            'width' => $options->getWidth(),
            'height' => $options->getHeight()
        ]);

        return $this->image->assignResource($newImage);
    }
}
