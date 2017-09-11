<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 12.41
 */

namespace Jackal\ImageMerge\Factory;

use Jackal\ImageMerge\Command\CommandInterface;
use Jackal\ImageMerge\Model\Image;

class CommandFactory
{
    /**
     * @param $className
     * @param Image $image
     * @param $options
     * @return CommandInterface
     * @throws \Exception
     */
    public static function getInstance($className, Image $image, $options)
    {
        if (!class_exists($className)) {
            throw new \Exception(sprintf('Class %s not found', $className));
        }

        return new $className($image, $options);
    }
}
