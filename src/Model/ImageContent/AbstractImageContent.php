<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 28/11/17
 * Time: 23:14
 */

namespace Jackal\ImageMerge\Model\ImageContent;


abstract class AbstractImageContent implements ImageContentInterface
{
    protected $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function __toString()
    {
        return $this->content;
    }

    public function getContent()
    {
        return $this->content;
    }
}