<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 25/11/17
 * Time: 00:29
 */

namespace Jackal\ImageMerge\Metadata\Parser;


use Jackal\ImageMerge\Metadata\Parser\ParserInterface;
use Jackal\ImageMerge\Model\File\File;

class IPTCParser extends AbstractParser
{

    const TITLE = '2#005';
    const URGENCY = '2#010';
    const CATEGORY = '2#015';
    const SUB_CATEGORY = '2#020';
    const SPECIAL_INSTRUCTION = '2#040';
    const CREATION_DATE = '2#055';
    const CREATION_TIME = '2#060';
    const DIGITAL_CREATION_DATE = '2#062';
    const DIGITAL_CREATION_TIME = '2#063';
    const BY_LINE = '2#080';
    const BY_LINE_TITLE = '2#085';
    const CITY = '2#090';
    const LOCATION = '2#092';
    const STATE = '2#095';
    const COUNTRY_CODE = '2#100';
    const COUNTRY_NAME = '2#101';
    const OTR = '2#103';
    const HEADLINE = '2#105';
    const CREDIT = '2#110';
    const SOURCE = '2#115';
    const COPYRIGHT = '2#116';
    const CONTACT = '2#118';
    const CAPTION = '2#120';
    const CAPTION_WRITER = '2#122';
    const CHARSET = '1#090';
    const KEYWORDS = '2#025';

    public function __construct(File $file)
    {
        $buffer = iptcembed("",$file->getPathname(),0);
        $size = getImageSize ($file->getPathname(), $info);

        if(isset($info['APP13'])){
            $this->data = iptcparse($info["APP13"]);
        }
    }

    public function getCategory(){
        return $this->getValue(self::CATEGORY);
    }

    public function getCreationDateTime(){
        if($this->getSingleValue(self::CREATION_DATE)) {
            $dt = trim($this->getSingleValue(self::CREATION_DATE) . ' ' . $this->getSingleValue(self::CREATION_TIME));
            return new \DateTime($dt);
        }
        return null;
    }

    public function getKeywords(){
        return $this->getValue(self::KEYWORDS);
    }

    public function isUTF8(){
        return $this->getSingleValue(self::CHARSET) == "\x1B%G";
    }

    public function getCreator(){
        return $this->getSingleValue(self::CAPTION_WRITER);
    }

    public function getDescription(){
        return $this->getSingleValue(self::CAPTION);
    }

    public function getCopyrights(){
        return $this->getSingleValue(self::COPYRIGHT);
    }


}