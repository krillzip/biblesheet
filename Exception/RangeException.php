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
 * Description of RangeException
 *
 * @author krillzip
 */
class RangeException extends Exception{
    public function __construct($message = 'Range error'){
        parent::__construct($message, Exception::RANGE_ERROR);
    }
}
