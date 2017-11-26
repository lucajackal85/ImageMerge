<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\CommandOptionInterface;
use Jackal\ImageMerge\Model\Image;

/**
 * Class AbstractCommand
 * @package Jackal\ImageMerge\Command
 */
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
