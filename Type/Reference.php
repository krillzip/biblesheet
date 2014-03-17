<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Krillzip\Biblesheet\Type;

/**
 * Description of Reference
 *
 * @author krillzip
 */
class Reference{

    public $reference;
    public $title;
    public $cell;
    public $info;
    public $book;
    public $verseCollection;
    
    public function __construct($reference, $cell, $title = null, $info = null){
        $this->reference = $reference;
        $this->cell = $cell;
        $this->title = $title;
        $this->info = $info;
    }

}
