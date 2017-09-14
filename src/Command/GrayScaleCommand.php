<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 18.02
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\CommandOptionInterface;
use Jackal\ImageMerge\Model\Image;

class GrayScaleCommand extends AbstractCommand
{
    public function __construct(Image $image)
    {
        parent::__construct($image, null);
    }

    /**
     * @return Image
     */
    public function execute()
    {
        imagefilter($this->image->getResource(), IMG_FILTER_GRAYSCALE);
        return $this->image;
    }
}
