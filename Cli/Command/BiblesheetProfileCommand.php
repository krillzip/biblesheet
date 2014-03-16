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
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;

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
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        $biblesheet = $this->getHelper('biblesheet')->get();
        $diathekeHelper = $this->getHelper('diatheke');
        
        $app = $this->getApplication();
        $command = $app->get('diatheke:config');
        
        $inputArr = new ArrayInput(array('diatheke:config'));
        $outputData = new StreamOutput(fopen('php://stdout', 'w'));
        $exitCode = $command->run($inputArr, $outputData);
        
        if($exitCode != 0){
            
        }
  
        $profiles = $biblesheet->getProfiles();
        $p = $profiles->getSkeleton();
        $p['profile']['configuration'] = $diathekeHelper->receiveMessage();
        
        $pName = $biblesheet->getSetting('defaultProfile');
        $profiles->saveProfile($pName, $p);
    }
}
