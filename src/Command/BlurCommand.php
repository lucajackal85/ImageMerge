<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 10.05
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use Jackal\ImageMerge\Model\Image;

class BlurCommand extends AbstractCommand
{
    public function __construct(Image $image, LevelCommandOption $options)
    {
        parent::__construct($image, $options);
    }

    public function execute()
    {
        if ($this->options->get('level')) {
            for ($i = 0; $i < $this->options->get('level'); $i++) {
                imagefilter($this->image->getResource(), IMG_FILTER_GAUSSIAN_BLUR);
            }
        }
        return $this->image;
    }
}
