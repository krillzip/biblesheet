<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Krillzip\Biblesheet\Exception;

use Krillzip\Biblesheet\Exception;
/**
 * Description of PreferenceException
 *
 * @author krillzip
 */
class PreferenceException extends Exception{
    public function __construct($message = 'Preferences error somewhere'){
        parent::__construct($message, Exception::PREFERENCE_ERROR);
    }
}
