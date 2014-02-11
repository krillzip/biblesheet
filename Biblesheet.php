<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Krillzip\Biblesheet;

use Krillzip\Biblesheet\Preferences;
use Krillzip\Biblesheet\Type\Sheet;
use Krillzip\Biblesheet\Type\Meta;
use Krillzip\Biblesheet\Type\Range;

use PHPExcel_Cell;

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
    
}
