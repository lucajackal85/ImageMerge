<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 10.05
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Model\Image;

class BlurCommand implements CommandInterface
{
    /**
     * @var
     */
    private $level;

    /**
     * @var Image
     */
    private $image;

    /**
     * BlurCommand constructor.
     * @param Image $image
     * @param $level
     */
    public function __construct(Image $image, $level)
    {
        $this->image = $image;
        $this->level = $level;
    }

    public function execute()
    {
        if ($this->level) {
            for ($i = 0; $i < $this->level; $i++) {
                imagefilter($this->image->getResource(), IMG_FILTER_GAUSSIAN_BLUR);
            }
        }
        return $this->image;
    }
}
