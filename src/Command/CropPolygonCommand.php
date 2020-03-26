<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Command\Options\MultiCoordinateCommandOption;
use Jackal\ImageMerge\Exception\InvalidColorException;
use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\Utils\ColorUtils;

/**
 * Class CropPolygonCommand
 * @package Jackal\ImageMerge\Command
 */
class CropPolygonCommand extends AbstractCommand
{
    /**
     * CropPolygonCommand constructor.
     * @param MultiCoordinateCommandOption|null $options
     */
    public function __construct(MultiCoordinateCommandOption $options = null)
    {
        parent::__construct($options);
    }

    /**
     * @param Image $image
     * @return Image
     * @throws InvalidColorException
     */
    public function execute(Image $image)
    {
        /** @var MultiCoordinateCommandOption $options */
        $options = $this->options;

        $builder = new ImageBuilder($image);

        // Setup the merge image from the source image with scaling
        $mergeImage = ImageCreateTrueColor($image->getWidth(), $image->getHeight());
        imagecopyresampled($mergeImage, $image->getResource(), 0, 0, 0, 0, $image->getWidth(), $image->getHeight(), imagesx($image->getResource()), imagesy($image->getResource()));

        $maskPolygon = imagecreatetruecolor($image->getWidth(), $image->getHeight());
        $borderColor = ColorUtils::colorIdentifier($maskPolygon, new Color('01feff'));
        imagefill($maskPolygon, 0, 0, $borderColor);

        // Add the transparent polygon mask
        $transparency = imagecolortransparent($maskPolygon, ColorUtils::colorIdentifier($maskPolygon, new Color('ff01fe')));
        imagesavealpha($maskPolygon, true);
        imagefilledpolygon($maskPolygon, $options->toArray(), $options->countPoints(), $transparency);

        // Apply the mask
        imagesavealpha($mergeImage, true);
        imagecopymerge($mergeImage, $maskPolygon, 0, 0, 0, 0, $image->getWidth(), $image->getHeight(), 100);

        // Create the final image
        $destImage = ImageCreateTrueColor($image->getWidth(), $image->getHeight());
        imagesavealpha($destImage, true);
        imagealphablending($destImage, true);
        imagecopy($destImage, $mergeImage,
            0, 0,
            0, 0,
            $image->getWidth(), $image->getHeight());

        // Make the the border transparent (we're assuming there's a 2px buffer on all sides)

        $borderTransparency = ColorUtils::colorIdentifier($destImage, new Color('ff01fe'), true);
        imagesavealpha($destImage, true);
        imagealphablending($destImage, true);
        imagefill($destImage, 0, 0, $borderTransparency);

        $image->assignResource($destImage);

        $builder->crop($options->getMinX(), $options->getMinY(), $options->getCropDimention()->getWidth(), $options->getCropDimention()->getHeight());

        return $image;
    }
}
