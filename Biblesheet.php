<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Krillzip\Biblesheet;

use Krillzip\Biblesheet\Preferences;
use Krillzip\Biblesheet\Profiles;
use Krillzip\Biblesheet\Type\Sheet;
use Krillzip\Biblesheet\Type\Meta;
use Krillzip\Biblesheet\Type\Range;

use Krillzip\Diatheke\Configuration;
use PHPExcel_Cell;

/**
 * Description of Biblesheet
 *
 * @author krillzip
 */
class Biblesheet {
    
    const REGEX = '/([1|2|3]?([i|I]+)?(\s?)\w+(\s+?))((\d+)?(,?)(\s?)(\d+))+(:?)((\d+)?([\-–]\d+)?(,(\s?)\d+[\-–]\d+)?)?/';
    protected $preferences;
    protected $profiles;
    
    public function __construct() {
        $this->preferences = new Preferences();
        $this->profiles = new Profiles();
    }
    
    public function getPreferences(){
        return $this->preferences;
    }
    
    public function getSetting($path){
        return $this->preferences->getSetting($path);
    }
    
    public function getProfiles(){
        return $this->profiles;
    }
    
    public function getProfile($name){
        return $this->profiles->loadProfile($name);
    }
    
    public function openSheet($path){
        if(!(is_readable($path) && is_file($path))){
            return false;
        }
        return new Sheet($path);
    }
    
    public function headingRange(Meta $meta){
        $range = $meta->getRange();
        $headingRow = $meta->getHeadings();
        
        if(($range == null) || ($headingRow == null)){
            return false;
        }
        $temp = PHPExcel_Cell::getRangeBoundaries($range);
        $temp[0][1] = $temp[1][1]= $headingRow;
        return join('', $temp[0]).':'.join('', $temp[1]);
    }
    
    public function walkSheet(Sheet $sheet, $rangeOrMeta = null){
        return Range::factory($sheet, $rangeOrMeta);
    }
    
    public function extractMeta(Sheet $sheet){
        return Meta::factory($sheet);
    }
    
    public function getDiathekeConfiguration() {
        $dp = $this->getSetting('defaultProfile');
        $profile = $this->profiles->loadProfile($dp);
        return new Configuration($profile['configuration']);
    }
}
