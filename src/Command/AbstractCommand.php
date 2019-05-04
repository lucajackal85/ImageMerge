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
     * @var CommandOptionInterface
     */
    protected $options;

    /**
     * AbstractCommand constructor.
     * @param CommandOptionInterface|null $options
     */
    public function __construct(CommandOptionInterface $options = null)
    {
        $this->options = $options;
    }
}
