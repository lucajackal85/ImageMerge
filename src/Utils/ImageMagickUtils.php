<?php


namespace Jackal\ImageMerge\Utils;


use Symfony\Component\Finder\Finder;

class ImageMagickUtils
{
    public static function getImageMagickBin(array $binFolders =['/usr/local/bin', '/usr/bin']){

        $finder = new Finder();
        $finder->in($binFolders);

        $finder->files()->name('convert');


        if (!$finder->count()) {
            throw new \RuntimeException(sprintf('Cannot find ImageMagick binaries [Looked into: %s]', implode(',', $binFolders)));
        }

        return $finder->getIterator()->current()->getPathName();
    }
}