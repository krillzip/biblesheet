<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Krillzip\Biblesheet\Cli\Helper;

use Krillzip\Biblesheet\Biblesheet;
use Krillzip\Diatheke\Diatheke;
use Symfony\Component\Console\Helper\Helper;

/**
 * Description of DiathekeHelper
 *
 * @author krillzip
 */
class BiblesheetHelper extends Helper{
    
    protected static $biblesheet;
    protected static $diatheke;
    
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
