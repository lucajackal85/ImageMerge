<?php

namespace Jackal\ImageMerge\Metadata\Parser;

use Jackal\ImageMerge\Model\File\FileInterface;

/**
 * Class XMPParser
 * @package Jackal\ImageMerge\Metadata\Parser
 */
class XMPParser extends AbstractParser
{
    /**
     * XMPParser constructor.
     * @param FileInterface $file
     */
    public function __construct(FileInterface $file){

        $content = $file->getContents();

        $xmp_data_start = strpos($content, '<x:xmpmeta');
        $xmp_data_end = strpos($content, '</x:xmpmeta>');

        $xmp_data = '';
        if($xmp_data_start !== false) {
            $xmp_length = $xmp_data_end - $xmp_data_start;
            $xmp_data = substr($content, $xmp_data_start, $xmp_length + 12);
        }

        $xmp_arr = [];
        foreach ([
                     'creator_email' => '<Iptc4xmpCore:CreatorContactInfo[^>]+?CiEmailWork="([^"]*)"',
                     'owner'    => '<rdf:Description[^>]+?aux:OwnerName="([^"]*)"',
                     'created_at' => '<rdf:Description[^>]+?xmp:CreateDate="([^"]*)"',
                     'modified_at'     => '<rdf:Description[^>]+?xmp:ModifyDate="([^"]*)"',
                     'label'         => '<rdf:Description[^>]+?xmp:Label="([^"]*)"',
                     'credit'        => '<rdf:Description[^>]+?photoshop:Credit="([^"]*)"',
                     'source'        => '<rdf:Description[^>]+?photoshop:Source="([^"]*)"',
                     'caption_writer'=> '<rdf:Description[^>]+?photoshop:CaptionWriter="([^"]*)"',

                     'photomechanic_prefs'=> '<rdf:Description[^>]+?photomechanic:Prefs="([^"]*)"',
                     'photomechanic_pm_version'=> '<rdf:Description[^>]+?photomechanic:PMVersion="([^"]*)"',
                     'photomechanic_tagged'=> '<rdf:Description[^>]+?photomechanic:Tagged="([^"]*)"',
                     'photomechanic_color_class'=> '<rdf:Description[^>]+?photomechanic:ColorClass="([^"]*)"',

                     'headline'      => '<rdf:Description[^>]+?photoshop:Headline="([^"]*)"',
                     'city'          => '<rdf:Description[^>]+?photoshop:City="([^"]*)"',
                     'state'         => '<rdf:Description[^>]+?photoshop:State="([^"]*)"',
                     'country'       => '<rdf:Description[^>]+?photoshop:Country="([^"]*)"',
                     'country_code'  => '<rdf:Description[^>]+?Iptc4xmpCore:CountryCode="([^"]*)"',
                     'location'      => '<rdf:Description[^>]+?Iptc4xmpCore:Location="([^"]*)"',
                     'title'         => '<dc:title>\s*<rdf:Alt>\s*(.*?)\s*<\/rdf:Alt>\s*<\/dc:title>',
                     'description'   => '<dc:description>\s*<rdf:Alt>\s*(.*?)\s*<\/rdf:Alt>\s*<\/dc:description>',
                     'creator'       => '<dc:creator>\s*<rdf:Seq>\s*(.*?)\s*<\/rdf:Seq>\s*<\/dc:creator>',
                     'keywords'      => '<dc:subject>\s*<rdf:Bag>\s*(.*?)\s*<\/rdf:Bag>\s*<\/dc:subject>',
                     'rights'      => '<dc:Rights>\s*(.*?)\s*<\/dc:Rights>',
                 ] as $key => $regex ) {

            // get a single text string
            $xmp_arr[$key] = preg_match( "/$regex/is", $xmp_data, $match ) ? $match[1] : '';

            // if string contains a list, then re-assign the variable as an array with the list elements
            $xmp_arr[$key] = preg_match_all( "/<rdf:li[^>]*>([^>]*)<\/rdf:li>/is", $xmp_arr[$key], $match ) ? $match[1] : $xmp_arr[$key];

            $this->data[$key] = $this->sanitizeChars($xmp_arr[$key]);

        }

    }

    /**
     * @return array
     */
    public function getPhotoMechanic(){
        return [
            'prefs' => $this->getSingleValue('photomechanic_prefs'),
            'pm_version' => $this->getSingleValue('photomechanic_pm_version'),
            'tagged' => $this->getBooleanValue('photomechanic_tagged'),
            'color_class' => $this->getSingleValue('photomechanic_color_class')
        ];
    }

    /**
     * @return null|string
     */
    public function getCaptionWriter(){
        return $this->getSingleValue('caption_writer');
    }

    /**
     * @return null|string
     */
    public function getCreator(){
        return $this->getSingleValue('creator');
    }

    /**
     * @return null|string
     */
    public function getDescription(){
        return $this->getSingleValue('description');
    }

    /**
     * @return \DateTime
     */
    public function getCreationDateTime(){
        return new \DateTime($this->getSingleValue('created_at'));
    }

    /**
     * @return array|null|string
     */
    public function getKeywords(){
        return $this->getValue('keywords');
    }

    /**
     * @return mixed
     */
    public function getCopyrights(){
        return $this->data['rights'];
    }

    /**
     * @param $valueArr
     * @return mixed
     */
    private function sanitizeChars($valueArr){
        if(is_array($valueArr)) {
            foreach($valueArr as &$value) {
                $value = preg_replace('/&#x(A{1});/', "\n", $value);
            }
        }

        return $valueArr;
    }
}