<?php

namespace Jackal\ImageMerge\Metadata\Parser;

use DateTime;
use Exception;
use Jackal\ImageMerge\Model\File\FileObjectInterface;

/**
 * Class IPTCParser
 * @package Jackal\ImageMerge\Metadata\Parser
 */
class IPTCParser extends AbstractParser
{
    public const TITLE = '2#005';
    public const URGENCY = '2#010';
    public const CATEGORY = '2#015';
    public const SUB_CATEGORY = '2#020';
    public const SPECIAL_INSTRUCTION = '2#040';
    public const CREATION_DATE = '2#055';
    public const CREATION_TIME = '2#060';
    public const DIGITAL_CREATION_DATE = '2#062';
    public const DIGITAL_CREATION_TIME = '2#063';
    public const BY_LINE = '2#080';
    public const BY_LINE_TITLE = '2#085';
    public const CITY = '2#090';
    public const LOCATION = '2#092';
    public const STATE = '2#095';
    public const COUNTRY_CODE = '2#100';
    public const COUNTRY_NAME = '2#101';
    public const OTR = '2#103';
    public const HEADLINE = '2#105';
    public const CREDIT = '2#110';
    public const SOURCE = '2#115';
    public const COPYRIGHT = '2#116';
    public const CONTACT = '2#118';
    public const CAPTION = '2#120';
    public const CAPTION_WRITER = '2#122';
    public const CHARSET = '1#090';
    public const KEYWORDS = '2#025';

    /**
     * IPTCParser constructor.
     * @param FileObjectInterface $file
     */
    public function __construct(FileObjectInterface $file)
    {
        @iptcembed('', $file->getPathname(), 0);
        $info = null;
        getimagesize($file->getPathname(), $info);

        if (isset($info['APP13'])) {
            $this->data = iptcparse($info['APP13']);
        }
    }

    /**
     * @return array|null|string
     */
    public function getCategory()
    {
        return $this->getValue(self::CATEGORY);
    }

    /**
     * @return DateTime|null
     * @throws Exception
     */
    public function getCreationDateTime()
    {
        if ($this->getSingleValue(self::CREATION_DATE)) {
            $dt = trim($this->getSingleValue(self::CREATION_DATE) . ' ' . $this->getSingleValue(self::CREATION_TIME));

            return new DateTime($dt);
        }

        return null;
    }

    /**
     * @return array|null|string
     */
    public function getKeywords()
    {
        return $this->getValue(self::KEYWORDS);
    }

    /**
     * @return bool
     */
    public function isUTF8()
    {
        return $this->getSingleValue(self::CHARSET) == "\x1B%G";
    }

    /**
     * @return null|string
     */
    public function getCreator()
    {
        return $this->getSingleValue(self::CAPTION_WRITER);
    }

    /**
     * @return null|string
     */
    public function getDescription()
    {
        return $this->getSingleValue(self::CAPTION);
    }

    public function getCopyrights()
    {
        return $this->getSingleValue(self::COPYRIGHT);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function toArray()
    {
        return [
            'category' => $this->getCategory(),
            'created_at' => $this->getCreationDateTime(),
            'keywords' => $this->getKeywords(),
            'utf8' => $this->isUTF8(),
            'created_by' => $this->getCreator(),
            'description' => $this->getDescription(),
            'copyrights' => $this->getCopyrights(),
        ];
    }
}
