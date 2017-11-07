<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 15.03
 */

namespace Jackal\ImageMerge\Command;

use Jackal\ImageMerge\Command\Options\BorderCommandOption;
use Jackal\ImageMerge\Command\Options\DoubleCoordinateColorCommandOption;
use Jackal\ImageMerge\Command\Asset\LineAssetCommand;
use Jackal\ImageMerge\Model\Image;

class BorderCommand extends AbstractCommand
{
    public function __construct(Image $image, BorderCommandOption $options)
    {
        parent::__construct($image, $options);
    }

    public function execute()
    {
        /** @var BorderCommandOption $options */
        $options = $this->options;

        for ($i=0;$i<$options->getStroke();$i++) {
            //top
            $this->image->addCommand(
                LineAssetCommand::class,
                    new DoubleCoordinateColorCommandOption(0,
                        $i,
                        $this->image->getWidth(),
                        $i,
                        $options->getColors()
                    )
            );
            //bottom
            $this->image->addCommand(
                LineAssetCommand::class,
                    new DoubleCoordinateColorCommandOption(
                        0,
                        $this->image->getHeight() - $i - 1,
                        $this->image->getWidth(),
                        $this->image->getHeight() - $i - 1,
                        $options->getColors()
                )
            );
            //right
            $this->image->addCommand(
                LineAssetCommand::class,
                    new DoubleCoordinateColorCommandOption(
                        $this->image->getWidth() - $i -1,
                        0,
                        $this->image->getWidth() - $i -1,
                        $this->image->getHeight(),
                        $options->getColors()
                )
            );
            //left
            $this->image->addCommand(
                LineAssetCommand::class,
                    new DoubleCoordinateColorCommandOption(
                        $i,
                        0,
                        $i,
                        $this->image->getHeight(),
                        $options->getColors()
                    )
            );
        }


        return $this->image;
    }
}
