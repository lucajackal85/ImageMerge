<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 11.26
 */

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Coordinate;
use Jackal\ImageMerge\Model\Font\Font;
use Jackal\ImageMerge\Model\Text\Text;

class TextCommandOption extends SingleCoordinateColorCommandOption
{
    public function __construct(Text $text, Coordinate $coordinate)
    {
        parent::__construct($coordinate,$text->getColor());
        $this->add('text', $text);
    }

    public function getText()
    {
        return $this->get('text');
    }
}
