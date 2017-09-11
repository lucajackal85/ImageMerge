<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 09/09/17
 * Time: 9.38
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\CommandOptionInterface;
use Jackal\ImageMerge\Model\Image;

interface CommandInterface
{
    public function __construct(Image $image,CommandOptionInterface $options);

    public function execute();
}
