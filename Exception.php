<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Krillzip\Biblesheet;

/**
 * Description of Exception
 *
 * @author krillzip
 */
class Exception extends \Exception{
    const PREFERENCE_ERROR = 1;
    const META_ERROR = 2;
    const RANGE_ERROR = 3;
}
