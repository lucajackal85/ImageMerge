<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 9.38
 */

namespace Jackal\ImageMerge\Command;

class RotateCommand extends AbstractCommand
{
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
