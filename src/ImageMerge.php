<?php


namespace Jackal\ImageMerge;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Metadata\Metadata;
use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Model\File\FileTempObject;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\Strategy\ImageBuilderContentStrategy;
use Jackal\ImageMerge\Strategy\ImageBuilderFileObjectStrategy;
use Jackal\ImageMerge\Strategy\ImageBuilderFileStrategy;
use Jackal\ImageMerge\Strategy\ImageBuilderImageStrategy;
use Jackal\ImageMerge\Strategy\ImageBuilderResourceStrategy;
use Jackal\ImageMerge\Strategy\ImageBuilderStrategyInterface;
use Jackal\ImageMerge\Strategy\ImageBuilderURLStrategy;

class ImageMerge
{
    private $strategies = [
        ImageBuilderContentStrategy::class,
        ImageBuilderFileStrategy::class,
        ImageBuilderFileObjectStrategy::class,
        ImageBuilderImageStrategy::class,
        ImageBuilderURLStrategy::class,
        ImageBuilderResourceStrategy::class
    ];

    /**
     * @param Image|FileObject|string $source
     * @return ImageBuilder
     * @throws \Exception
     */
    public function getImageBuilder($source)
    {
        foreach ($this->strategies as $strategyClass) {
            $strategy = new $strategyClass;
            if ($strategy->support($source)) {
                return $strategy->getImageBuilder($source);
            }
        }

        throw new \Exception('No strategy found, cannot create ImageBuilder');
    }

    public function registerImageBuilderStrategy(ImageBuilderStrategyInterface $strategy)
    {
        $this->strategies[] = get_class($strategy);
    }
}
