<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Krillzip\Biblesheet\Cli\Helper;

use Krillzip\Biblesheet\Biblesheet;
use Symfony\Component\Console\Helper\Helper;
/**
 * Description of DiathekeHelper
 *
 * @author krillzip
 */
class BiblesheetHelper extends Helper{
    
    protected static $biblesheet;
    
    public function getName(){
        return 'biblesheet';
    }
    
    public function get(){
        if(!self::$biblesheet){
            self::$biblesheet = new Biblesheet();
        }
        return self::$biblesheet;
    }
}
