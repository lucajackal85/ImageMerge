<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 12/09/17
 * Time: 9.22
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\MultiCoordinateCommandOption;
use Jackal\ImageMerge\Model\Image;

class CropPolygonCommand extends AbstractCommand
{
    public function __construct(Image $image, MultiCoordinateCommandOption $options = null)
    {
        parent::__construct($image, $options);
    }


    /**
     * @return Image
     */
    public function execute()
    {
        /** @var MultiCoordinateCommandOption $options */
        $options = $this->options;

        // Setup the merge image from the source image with scaling
        $mergeImage = ImageCreateTrueColor($this->image->getWidth(), $this->image->getHeight());
        imagecopyresampled($mergeImage, $this->image->getResource(), 0, 0, 0, 0, $this->image->getWidth(), $this->image->getHeight(), imagesx($this->image->getResource()), imagesy($this->image->getResource()));

        $maskPolygon = imagecreatetruecolor($this->image->getWidth(), $this->image->getHeight());
        $borderColor = imagecolorallocate($maskPolygon, 1, 254, 255);
        imagefill($maskPolygon, 0, 0, $borderColor);

        // Add the transparent polygon mask
        $transparency = imagecolortransparent($maskPolygon, imagecolorallocate($maskPolygon, 255, 1, 254));
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
        $borderRGB = imagecolorallocate($destImage, 255, 1, 254);
        $borderTransparency = imagecolorallocatealpha($destImage, 255,
            1, $borderRGB['blue'], 127);
        imagesavealpha($destImage, true);
        imagealphablending($destImage, true);
        imagefill($destImage, 0, 0, $borderTransparency);

        $this->image->assignResource($destImage);

        $this->image->crop($options->getMinX(), $options->getMinY(), $options->getCropWidth(), $options->getCropHeight());

        return $this->image;
    }
}