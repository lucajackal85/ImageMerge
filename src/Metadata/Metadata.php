<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 10/11/17
 * Time: 9.15
 */

namespace Jackal\ImageMerge\Metadata;

use Jackal\ImageMerge\Model\File\File;

class Metadata
{
    private $metadata;
    private $xmp;

    public function __construct(File $file)
    {
        $this->metadata = exif_read_data($file->getPathname());
        $this->xmp = $this->parseXMP($file);
    }

    public function all(){
        return $this->metadata;
    }

    public function getCameraMake()
    {
        return $this->metadata['Make'];
    }

    public function getCameraModel()
    {
        return $this->metadata['Model'];
    }

    public function getCameraExposure()
    {
        return $this->metadata['ExposureTime'];
    }

    public function getCameraAperture(){


    }

    public function getCameraFocalLength(){
        $length = $this->metadata['FocalLength'];
        if(strpos($length,'/1') !== false) {
            return (int)str_replace('/1', '', $length);
        }

        return $length;
    }

    public function getCameraISO(){
        return $this->metadata['ISOSpeedRatings'];
    }

    public function getCameraFlash(){

        return $this->metadata['Flash'] == true;
    }

    public function getXMP(){
        return $this->xmp;
    }

    private function parseXMP(File $file){

        $content = $file->getContents();

        $xmp_data_start = strpos($content, '<x:xmpmeta');
        $xmp_data_end = strpos($content, '</x:xmpmeta>');

        if($xmp_data_start !== false) {
            $xmp_length = $xmp_data_end - $xmp_data_start;
            $xmp_data = substr($content, $xmp_data_start, $xmp_length + 12);
            $this->xmp = $xmp_data;
        }

        $xmp_arr = array();
        foreach ( array(
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
                  ) as $key => $regex ) {

            // get a single text string
            $xmp_arr[$key] = preg_match( "/$regex/is", $this->xmp, $match ) ? $match[1] : '';

            // if string contains a list, then re-assign the variable as an array with the list elements
            $xmp_arr[$key] = preg_match_all( "/<rdf:li[^>]*>([^>]*)<\/rdf:li>/is", $xmp_arr[$key], $match ) ? $match[1] : $xmp_arr[$key];

            // hierarchical keywords need to be split into a third dimension
            if ( ! empty( $xmp_arr[$key] ) && $key == 'Hierarchical Keywords' ) {
                foreach ( $xmp_arr[$key] as $li => $val ) {
                    $xmp_arr[$key][$li] = explode( '|', $val );
                }
                unset ( $li, $val );
            }
        }
        return $xmp_arr;
    }
}
