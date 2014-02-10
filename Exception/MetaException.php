<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
