<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 15.07
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\CommandOptionInterface;
use Jackal\ImageMerge\Command\Options\CropCommandOption;
use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Model\Image;

class CropCenterCommand extends AbstractCommand
{
    public function __construct(Image $image, DimensionCommandOption $options)
    {
        parent::__construct($image, $options);
    }

    public function execute()
    {
        $width = $this->image->getWidth();
        $height = $this->image->getHeight();

        $newWidth = $this->options->getWidth();
        $newHeight = $this->options->getHeight();

        if ($newWidth > $width || $newHeight > $height) {
            throw new \Exception(sprintf('Crop area exceed, max dimensions are: %s X %s', $width, $height));
        }

        $x = ($width- $newWidth) / 2;
        $y = ($height - $newHeight) / 2;

        $this->image->addCommand(CropCommand::class, new CropCommandOption($x, $y, $newWidth, $newHeight));
    }
}
