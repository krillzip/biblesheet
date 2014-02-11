<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Krillzip\Biblesheet\Exception;

use Krillzip\Biblesheet\Exception;
/**
 * Description of MetaException
 *
 * @author krillzip
 */
class MetaException  extends Exception{
    public function __construct($message = 'Meta error'){
        parent::__construct($message, Exception::META_ERROR);
    }
}
