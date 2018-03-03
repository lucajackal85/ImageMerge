<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\MultiCoordinateCommandOption;
use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\Utils\ColorUtils;

/**
 * Class CropPolygonCommand
 * @package Jackal\ImageMerge\Command
 */
class CropPolygonCommand extends AbstractCommand
{

    const CLASSNAME = __CLASS__;


    /**
     * CropPolygonCommand constructor.
     * @param Image $image
     * @param MultiCoordinateCommandOption|null $options
     */
    public function __construct(Image $image, MultiCoordinateCommandOption $options = null)
    {
        parent::__construct($image, $options);
    }


    /**
     * @return Image
     * @throws \Jackal\ImageMerge\Exception\InvalidColorException
     */
    public function execute()
    {
        /** @var MultiCoordinateCommandOption $options */
        $options = $this->options;

        // Setup the merge image from the source image with scaling
        $mergeImage = ImageCreateTrueColor($this->image->getWidth(), $this->image->getHeight());
        imagecopyresampled($mergeImage, $this->image->getResource(), 0, 0, 0, 0, $this->image->getWidth(), $this->image->getHeight(), imagesx($this->image->getResource()), imagesy($this->image->getResource()));

        $maskPolygon = imagecreatetruecolor($this->image->getWidth(), $this->image->getHeight());
        $borderColor = ColorUtils::colorIdentifier($maskPolygon, new Color('01feff'));
        imagefill($maskPolygon, 0, 0, $borderColor);

        // Add the transparent polygon mask
        $transparency = imagecolortransparent($maskPolygon, ColorUtils::colorIdentifier($maskPolygon, new Color('ff01fe')));
        imagesavealpha($maskPolygon, true);
        imagefilledpolygon($maskPolygon, $options->getCoordinates(), $options->countPoints(), $transparency);

        // Apply the mask
        imagesavealpha($mergeImage, true);
        imagecopymerge($mergeImage, $maskPolygon, 0, 0, 0, 0, $this->image->getWidth(), $this->image->getHeight(), 100);

        // Create the final image
        $destImage = ImageCreateTrueColor($this->image->getWidth(), $this->image->getHeight());
        imagesavealpha($destImage, true);
        imagealphablending($destImage, true);
        imagecopy($destImage, $mergeImage,
            0, 0,
            0, 0,
            $this->image->getWidth(), $this->image->getHeight());

        // Make the the border transparent (we're assuming there's a 2px buffer on all sides)

        $borderTransparency = ColorUtils::colorIdentifier($destImage, new Color('ff01fe'), true);
        imagesavealpha($destImage, true);
        imagealphablending($destImage, true);
        imagefill($destImage, 0, 0, $borderTransparency);

        $this->image->assignResource($destImage);

        $this->image->crop($options->getMinX(), $options->getMinY(), $options->getCropWidth(), $options->getCropHeight());

        return $this->image;
    }
}
