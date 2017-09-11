<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 16.31
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Model\Image;

class ThumbnailCommand extends AbstractCommand
{
    public function __construct(Image $image, DimensionCommandOption $options)
    {
        parent::__construct($image, $options);
    }

    public function execute()
    {
        /** @var DimensionCommandOption $options */
        $options = $this->options;

        if (!$options->getWidth() and !$options->getHeight()) {
            throw new \Exception('Both width and height are empy value');
        }

        if (!$options->getWidth()) {
            $options->add('width', $options->getWidth() ? $options->getWidth() : round($this->image->getAspectRatio() * $options->getHeight()));
        }

        if (!$options->getHeight()) {
            $options->add('height', $options->getHeight() ? $options->getHeight() : round($options->getWidth() / $this->image->getAspectRatio()));
        }

        $thumbAspect = $options->getWidth() / $options->getHeight();

        if ($this->image->getAspectRatio() >= $thumbAspect) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $newHeight = $options->getHeight();
            $newWidth = $this->image->getWidth() / ($this->image->getHeight() / $options->getHeight());
        } else {
            // If the thumbnail is wider than the image
            $newHeight = $this->image->getHeight() / ($this->image->getWidth() / $options->getWidth());
            $newWidth = $options->getWidth();
        }

        $this->image->resize($newWidth, $newHeight);
        $this->image->cropCenter($options->getWidth(), $options->getHeight());

        return $this->image;
    }
}
