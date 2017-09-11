<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 9.38
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Model\Image;

interface CommandInterface
{
    /**
     * @return Image
     */
    public function execute();
}
