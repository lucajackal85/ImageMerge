<?php


namespace Jackal\ImageMerge\Command\Effect;


use Jackal\ImageMerge\Command\AbstractCommand;
use Symfony\Component\Finder\Finder;

abstract class AbstractImageMagickCommand extends AbstractCommand
{
    /**
     *
     */
    protected function getImageMagickBin()
    {
        $binFolders =[
            '/usr/local/bin',
            '/usr/bin',
        ];

        $finder = new Finder();
        $finder->in($binFolders);

        $finder->files()->name('convert');


        if (!$finder->count()) {
            throw new \RuntimeException(sprintf('Cannot find ImageMagick binaries [Looked into: %s]', implode(',', $binFolders)));
        }

        return $finder->getIterator()->current()->getPathName();
    }
}