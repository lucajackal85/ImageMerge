<?php

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Command\Asset\LineAssetCommand;
use Jackal\ImageMerge\Command\Options\BorderCommandOption;
use Jackal\ImageMerge\Command\Options\DoubleCoordinateColorCommandOption;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\ValueObject\Coordinate;

/**
 * Class BorderCommand
 * @package Jackal\ImageMerge\Command
 */
class BorderCommand extends AbstractCommand
{
    /**
     * BorderCommand constructor.
     */
    public function __construct(BorderCommandOption $options)
    {
        parent::__construct($options);
    }

    public function execute(Image $image): Image
    {
        /** @var BorderCommandOption $options */
        $options = $this->options;

        // a stroke wider than half the image just repaints the same pixels
        $stroke = min((int) $options->getStroke(), (int) ceil(min($image->getWidth(), $image->getHeight()) / 2));

        for ($i = 0; $i < $stroke; $i++) {
            $builder = new ImageBuilder($image);

            $builder->addCommand(
                new LineAssetCommand(
                    new DoubleCoordinateColorCommandOption(
                        new Coordinate(0, $i),
                        new Coordinate($image->getWidth(), $i),
                        $options->getColor()
                    )
                )
            );
            //bottom
            $builder->addCommand(
                new LineAssetCommand(
                    new DoubleCoordinateColorCommandOption(
                        new Coordinate(0, $image->getHeight() - $i - 1),
                        new Coordinate($image->getWidth(), $image->getHeight() - $i - 1),
                        $options->getColor()
                    )
                )
            );
            //right
            $builder->addCommand(
                new LineAssetCommand(
                    new DoubleCoordinateColorCommandOption(
                        new Coordinate($image->getWidth() - $i - 1, 0),
                        new Coordinate($image->getWidth() - $i - 1, $image->getHeight()),
                        $options->getColor()
                    )
                )
            );
            //left
            $builder->addCommand(
                new LineAssetCommand(
                    new DoubleCoordinateColorCommandOption(
                        new Coordinate($i, 0),
                        new Coordinate($i, $image->getHeight()),
                        $options->getColor()
                    )
                )
            );
        }

        return $image;
    }
}
