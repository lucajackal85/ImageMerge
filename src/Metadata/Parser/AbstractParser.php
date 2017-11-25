<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 25/11/17
 * Time: 14:04
 */

namespace Jackal\ImageMerge\Metadata\Parser;


use Jackal\ImageMerge\Model\File\File;

abstract class AbstractParser implements ParserInterface
{
    protected $data = [];

    public function isEmpty(){
        return !$this->data;
    }

    protected function getValue($key){
        if(isset($this->data[$key])){
            return $this->data[$key];
        }
        return null;
    }

    protected function getDivisionValue($key){
        $value = $this->getValue($key);
        if(strpos($value,'/1') !== false) {
            return (int)str_replace('/1', '', $value);
        }else{
            return $value;
        }
    }

    protected function getBooleanValue($key){
        $value = $this->getSingleValue($key);
        if(is_null($value)){
            return $value;
        }
        return $value == true and strtolower($value) != 'false';
    }

    protected function removeEmptyData($data){
        if(is_string($data) and $data == ''){
            return null;
        }
        return $data;
    }

    protected function getSingleValue($key){
        $value = $this->getValue($key);
        if(is_array($value)) {
            $value = array_shift($this->getValue($key));
        }
        $value = preg_replace('/[\r\n]/',"\n",$value);
        return $value;
    }

}