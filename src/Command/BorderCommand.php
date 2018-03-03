<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Command\Options\BorderCommandOption;
use Jackal\ImageMerge\Command\Options\DoubleCoordinateColorCommandOption;
use Jackal\ImageMerge\Command\Asset\LineAssetCommand;
use Jackal\ImageMerge\Model\Coordinate;
use Jackal\ImageMerge\Model\Image;

/**
 * Class BorderCommand
 * @package Jackal\ImageMerge\Command
 */
class BorderCommand extends AbstractCommand
{

    const CLASSNAME = __CLASS__;

    /**
     * BorderCommand constructor.
     * @param Image $image
     * @param BorderCommandOption $options
     */
    public function __construct(Image $image, BorderCommandOption $options)
    {
        parent::__construct($image, $options);
    }

    /**
     * @return Image
     * @throws \Exception
     * @throws \Jackal\ImageMerge\Exception\InvalidColorException
     */
    public function execute()
    {
        /** @var BorderCommandOption $options */
        $options = $this->options;

        for ($i=0;$i<$options->getStroke();$i++) {

            $builder = ImageBuilder::fromImage($this->image);

            $builder->addCommand(
                LineAssetCommand::CLASSNAME,
                    new DoubleCoordinateColorCommandOption(
                        new Coordinate(0, $i),
                        new Coordinate($this->image->getWidth(), $i),
                        $options->getColors()
                    )
            );
            //bottom
            $builder->addCommand(
                LineAssetCommand::CLASSNAME,
                    new DoubleCoordinateColorCommandOption(
                        new Coordinate(0, $this->image->getHeight() - $i - 1),
                        new Coordinate($this->image->getWidth(), $this->image->getHeight() - $i - 1),
                        $options->getColors()
                )
            );
            //right
            $builder->addCommand(
                LineAssetCommand::CLASSNAME,
                    new DoubleCoordinateColorCommandOption(
                        new Coordinate($this->image->getWidth() - $i -1, 0),
                        new Coordinate($this->image->getWidth() - $i -1, $this->image->getHeight()),
                        $options->getColors()
                )
            );
            //left
            $builder->addCommand(
                LineAssetCommand::CLASSNAME,
                    new DoubleCoordinateColorCommandOption(
                        new Coordinate($i, 0),
                        new Coordinate($i, $this->image->getHeight()),
                        $options->getColors()
                    )
            );
        }


        return $this->image;
    }
}
