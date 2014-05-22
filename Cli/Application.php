<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Krillzip\Biblesheet\Cli;

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
        $this->add(new \Krillzip\Biblesheet\Cli\Command\BiblesheetTestCommand());
        $this->add(new \Krillzip\Diatheke\Cli\Command\DiathekeDiagnoseCommand());
        $this->add(new \Krillzip\Diatheke\Cli\Command\DiathekeListCommand());
        $this->add(new \Krillzip\Diatheke\Cli\Command\DiathekeConfigCommand());
        $this->add(new \Krillzip\Diatheke\Cli\Command\DiathekeSearchCommand());
        $this->add(new \Krillzip\Diatheke\Cli\Command\TestCommand());
        
        parent::__construct(static::NAME, static::VERSION);
    }
}
