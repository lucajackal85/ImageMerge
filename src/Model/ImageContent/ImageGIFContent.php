<?php

namespace Jackal\ImageMerge\Model\ImageContent;

/**
 * Class ImageGIFContent
 * @package Jackal\ImageMerge\Model\ImageContent
 */
class ImageGIFContent extends AbstractImageContent
{
    /**
     * @return string
     */
    public function getContentType()
    {
        return 'image/gif';
    }
}