<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Krillzip\Biblesheet\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of BiblesheetPrintCommand
 *
 * @author krillzip
 */
class BiblesheetTestCommand extends Command {

    protected function configure() {
        parent::configure();
        $this
                ->setName('biblesheet:test')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
         $tpl = new \Krillzip\Biblesheet\Template();
         var_dump($tpl->getList());
    }
}
