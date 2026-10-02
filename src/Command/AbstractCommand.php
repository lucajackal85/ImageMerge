<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\CommandOptionInterface;

/**
 * Class AbstractCommand
 * @package Jackal\ImageMerge\Command
 */
abstract class AbstractCommand implements CommandInterface
{
    /**
     * AbstractCommand constructor.
     */
    public function __construct(protected ?CommandOptionInterface $options = null)
    {
    }
}
