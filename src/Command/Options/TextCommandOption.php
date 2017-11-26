<?php

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Coordinate;
use Jackal\ImageMerge\Model\Text\Text;

/**
 * Class TextCommandOption
 * @package Jackal\ImageMerge\Command\Options
 */
class TextCommandOption extends SingleCoordinateColorCommandOption
{
    /**
     * TextCommandOption constructor.
     * @param Text $text
     * @param Coordinate $coordinate
     */
    public function __construct(Text $text, Coordinate $coordinate)
    {
        parent::__construct($coordinate,$text->getColor());
        $this->add('text', $text);
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->get('text');
    }
}
