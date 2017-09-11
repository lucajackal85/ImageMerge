<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 9.38
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\LevelCommandOption;
use Jackal\ImageMerge\Model\Image;

class RotateCommand extends AbstractCommand
{
    public function __construct(Image $image, LevelCommandOption $options)
    {
        parent::__construct($image, $options);
    }

    public function execute()
    {
        $degree = $this->options->getLevel();
        $resource = $this->image->getResource();
        if ($degree and ($degree % 360)) {
            $resource = imagerotate($resource, $degree, 0);
        }
        return $this->image->assignResource($resource);
    }
}
