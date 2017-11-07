<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 18.07
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\CommandOptionInterface;
use Jackal\ImageMerge\Model\Image;

abstract class AbstractCommand implements CommandInterface
{
    /**
     * @var Image
     */
    protected $image;

    /**
     * @var CommandOptionInterface
     */
    protected $options;

    public function __construct(Image $image, CommandOptionInterface $options = null)
    {
        $this->image = $image;
        $this->options = $options;
    }
}
