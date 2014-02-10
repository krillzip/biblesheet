<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Krillzip\Biblesheet;

use Krillzip\Biblesheet\Preferences;
use Krillzip\Biblesheet\Type\Sheet;
/**
 * Description of Biblesheet
 *
 * @author krillzip
 */
class Biblesheet {
    
    const REGEX = '/([1|2|3]?([i|I]+)?(\s?)\w+(\s+?))((\d+)?(,?)(\s?)(\d+))+(:?)((\d+)?([\-–]\d+)?(,(\s?)\d+[\-–]\d+)?)?/';
    protected $preferences;
    
    public function __construct() {
        $this->preferences = new \Krillzip\Biblesheet\Preferences();
    }
    
    public function openSheet($path){
        if(!(is_readable($path) && is_file($path))){
            return false;
        }
        return new Sheet($path);
    }
    
    public static function extractReferences(Sheet $sheet, $range = null){
        $sheet->walkSelectedSheet($range);
        
    }
    
}
