<?php

namespace Jackal\ImageMerge\Model\ImageContent;

/**
 * Class ImageJPGContent
 * @package Jackal\ImageMerge\Model\ImageContent
 */
class ImageJPGContent extends AbstractImageContent
{
    /**
     * @return string
     */
    public function getContentType()
    {
        return 'image/jpg';
    }
}