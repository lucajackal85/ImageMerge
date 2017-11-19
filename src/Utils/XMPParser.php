<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 19/11/17
 * Time: 15:05
 */

namespace Jackal\ImageMerge\Utils;


use Jackal\ImageMerge\Model\File\File;

class XMPParser
{
    public static function parse(File $file){

        $xmpParser = new self();

        $content = $file->getContents();

        $xmp_data_start = strpos($content, '<x:xmpmeta');
        $xmp_data_end = strpos($content, '</x:xmpmeta>');

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

            $xmp_arr[$key] = $xmpParser->sanitizeChars($xmp_arr[$key]);

            if($xmpParser->isDateTimeFormat($xmp_arr[$key])){
                $xmp_arr[$key] = new \DateTime($xmp_arr[$key]);
            }

            $xmp_arr[$key] = $xmpParser->removeEmptyData($xmp_arr[$key]);

        }

        return $xmp_arr;

    }

    private function isDateTimeFormat($format){
        if(is_string($format)){
            preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}:[0-9]{2}\+[0-9]{2}:[0-9]{2}/',$format,$matches);

            return count($matches) > 0;
        }

        return false;
    }


    private function sanitizeChars($valueArr){
        if(is_array($valueArr)) {
            foreach($valueArr as &$value) {
                $value = preg_replace('/&#x(A{1});/', "\n", $value);
            }
        }

        return $valueArr;
    }

    private function removeEmptyData($data){
        if(is_string($data) and $data == ''){
            return null;
        }
        return $data;
    }
}