<?php

namespace Jackal\ImageMerge\Factory;

use Jackal\ImageMerge\Command\CommandInterface;
use Jackal\ImageMerge\Command\Options\CommandOptionInterface;
use Jackal\ImageMerge\Model\Image;

/**
 * Class CommandFactory
 * @package Jackal\ImageMerge\Factory
 */
class CommandFactory
{
    /**
     * @param $className
     * @param Image $image
     * @param CommandOptionInterface $options
     * @return CommandInterface
     * @throws \Exception
     */
    public static function getInstance($className, Image $image, CommandOptionInterface $options = null)
    {
        if (!class_exists($className)) {
            throw new \Exception(sprintf('Class %s not found', $className));
        }

        return new $className($image, $options);
    }
}
