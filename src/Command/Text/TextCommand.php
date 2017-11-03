<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 03/11/17
 * Time: 17.01
 */

namespace Jackal\ImageMerge\Command\Text;


use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\Asset\TextAsset;
use Jackal\ImageMerge\Command\Options\CommandOptionInterface;
use Jackal\ImageMerge\Command\Options\TextCommandOption;
use Jackal\ImageMerge\Model\Image;

class TextCommand extends AbstractCommand
{
    public function __construct(Image $image, CommandOptionInterface $options = null)
    {
        parent::__construct($image, $options);
    }


    /**
     * @return Image
     */
    public function execute()
    {
        $this->image->add(new TextAsset($this->image,$this->options));

        return $this->image;
    }
}