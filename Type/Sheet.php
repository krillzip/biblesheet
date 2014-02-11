<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Krillzip\Biblesheet\Type;

use Krillzip\Biblesheet\Type\Meta;
use Krillzip\Biblesheet\Type\Range;
use \PHPExcel_IOFactory;
/**
 * Description of SHeet
 *
 * @author krillzip
 */
class Sheet {

    protected $path;
    protected $document;
    protected $sheet;
    
    public function __construct($path) {
        $this->path = $path;
        $this->init();
    }
    
    protected function init(){
        $this->document = PHPExcel_IOFactory::load($this->path);
    }
    
    public function getSheetNames(){
        return $this->document->getSheetNames();
    }
    
    public function selectSheet($sheetIndex = null){
        $this->sheet = $this->document->getSheet($sheetIndex);
    }
    
    public function getSelectedSheet(){
        return $this->sheet;
    }
}
