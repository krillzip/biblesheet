<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Krillzip\Biblesheet\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of BiblesheetConfigCommand
 *
 * @author krillzip
 */
class BiblesheetProfileCommand extends Command{
    protected function configure() {
        parent::configure();
        $this
                ->setName('biblesheet:profile')
                /*->setDescription('Prints a sheet')
                ->setDefinition(array(
                    new InputArgument('file', InputArgument::REQUIRED, 'Path to sheet for printing'),
                    new InputOption('name', 'n', InputOption::VALUE_REQUIRED, 'Name or title of the sheet'),
                    new InputOption('template', 't', InputOption::VALUE_NONE, 'Template to use'),
                    new InputOption('profile', 'p', InputOption::VALUE_REQUIRED, 'Profile to apply'),
                ))
                ->setHelp(<<<EOT
The <info>biblesheet:print</info> command takes an Excel sheet and prints a bible reference booklet
EOT
                )*/
        ;
    }
}
