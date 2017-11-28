<?php

namespace Jackal\ImageMerge\Model\ImageContent;

/**
 * Class ImagePNGContent
 * @package Jackal\ImageMerge\Model\ImageContent
 */
class ImagePNGContent extends AbstractImageContent
{
    /**
     * @return string
     */
    public function getContentType()
    {
        return 'image/png';
    }
}