<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 11.26
 */

namespace Jackal\ImageMerge\Command\Options;

use Jackal\ImageMerge\Model\Font\Font;
use Jackal\ImageMerge\Model\Text\Text;

class TextCommandOption extends SingleCoordinateColorCommandOption
{
    public function __construct(Text $text, $x1, $y1)
    {
        parent::__construct($x1, $y1,$text->getColor());
        $this->add('text', $text);
    }

    public function getText()
    {
        return $this->get('text');
    }
}
