<?php

namespace Krillzip\Biblesheet;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Krillzip\Diatheke\Cli\Helper\DiathekeHelper;
use Krillzip\Biblesheet\Cli\Helper\BiblesheetHelper;
use Symfony\Component\Console\Application as BaseApplication;
/**
 * Description of Application
 *
 * @author krillzip
 */
class Application extends BaseApplication{
    const NAME = 'Biblesheet';
    const VERSION = '0.1d';
 
    public function __construct()
    {
        $helperSet = $this->getDefaultHelperSet();
        $helperSet->set(new BiblesheetHelper());
        $helperSet->set(new DiathekeHelper());
        $this->setHelperSet($helperSet);
        
        $this->add(new \Krillzip\Biblesheet\Cli\Command\BiblesheetPrintCommand());
        $this->add(new \Krillzip\Biblesheet\Cli\Command\BiblesheetProfileCommand());
        $this->add(new \Krillzip\Diatheke\Cli\Command\DiathekeDiagnoseCommand());
        $this->add(new \Krillzip\Diatheke\Cli\Command\DiathekeListCommand());
        $this->add(new \Krillzip\Diatheke\Cli\Command\DiathekeConfigCommand());
        
        parent::__construct(static::NAME, static::VERSION);
    }
}
