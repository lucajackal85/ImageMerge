<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 9.38
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Model\Image;

class RotateCommand implements CommandInterface
{
    private $image;
    private $degree;
    
    public function __construct(Image $image, $degree)
    {
        $this->degree =  $degree;
        $this->image = $image;
    }


    public function execute()
    {
        $resource = $this->image->getResource();
        if ($this->degree and ($this->degree % 360)) {
            $resource = imagerotate($resource, $this->degree, 0);
        }
        return $this->image->assignResource($resource);
    }
}
