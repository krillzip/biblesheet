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
 * Description of PreferenceException
 *
 * @author krillzip
 */
class ProfilesException extends Exception{
    public function __construct($message = 'Profile error somewhere'){
        parent::__construct($message, Exception::PROFILES_ERROR);
    }
}
