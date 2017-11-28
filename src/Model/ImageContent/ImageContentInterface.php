<?php

namespace Jackal\ImageMerge\Model\ImageContent;

/**
 * Interface ImageContentInterface
 * @package Jackal\ImageMerge\Model\ImageContent
 */
interface ImageContentInterface
{
    /**
     * ImageContentInterface constructor.
     * @param $content
     */
    public function __construct($content);

    /**
     * @return string
     */
    public function getContentType();

    /**
     * @return string
     */
    public function getContent();

    /**
     * @return string
     */
    public function __toString();
}