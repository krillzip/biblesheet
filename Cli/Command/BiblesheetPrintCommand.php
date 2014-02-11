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
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of BiblesheetPrintCommand
 *
 * @author krillzip
 */
class BiblesheetPrintCommand extends Command {

    protected function configure() {
        parent::configure();
        $this
                ->setName('biblesheet:print')
                ->setDescription('Prints a sheet')
                ->setDefinition(array(
                    new InputArgument('file', InputArgument::REQUIRED, 'Path to sheet for printing'),
                    new InputOption('title', 't', InputOption::VALUE_REQUIRED, 'Name or title of the sheet'),
                    new InputOption('template', 'm', InputOption::VALUE_REQUIRED, 'Template to use'),
                    new InputOption('profile', 'p', InputOption::VALUE_REQUIRED, 'Profile to apply'),
                    //new InputOption('sheet', 'w', InputOption::VALUE_REQUIRED, 'Sheet to print'),
                ))
                ->setHelp(<<<EOT
The <info>biblesheet:print</info> command takes an Excel sheet and prints a bible reference booklet
EOT
                )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        //$d = $this->getHelper('diatheke')->get();
        $dialog = $this->getHelper('dialog');
        $biblesheet = $this->getHelper('biblesheet')->get();
        
        $tpl = new \Krillzip\Biblesheet\Template();
        
        // Arguments and options
        $file = $input->getArgument('file');
        $title = $input->getOption('title');
        $template = $input->getOption('template');
        $profile = $input->getOption('profile');
        //$sheetIndex = $input->getOption('sheet');

        // Open file
        $sheet = $biblesheet->openSheet($file);
        if ($sheet === false) {
            $output->writeln('<error>Could not open: ' . $file . '</error>');
            return;
        }

        // Check witch worksheet to print
        $sheetNames = $sheet->getSheetNames();
        if (count($sheetNames) > 1) {
            $sheetIndex = $dialog->select(
                    $output, 'Select worksheet to print:' . PHP_EOL . '(<comment>Defaults to first sheet</comment>)', $sheetNames, 0
            );
        } else {
            $sheetIndex = 0;
        }

        $output->writeln('Will print from worksheet: <info>' . $sheetNames[$sheetIndex] . '</info>' . PHP_EOL);
        
        $sheet->selectSheet($sheetIndex);
        $meta = $biblesheet->extractMeta($sheet);

         if($meta === false){
             $output->writeln('<comment>No meta information extracted</comment>');
         }
         
         $collection = $biblesheet->walkSheet($sheet, ($meta !== false) ? $meta : null)->flattenData();
         
        // Check witch template to print with
        $tplList = $tpl->getList();
        //if (count(templates) > 1) {
            $tplIndex = $dialog->select(
                    $output, 'Select template to use:' . PHP_EOL . '(<comment>Defaults to basic</comment>)', $tplList, 0
            );
        //} else {
        //    $tplIndex = 0;
        //}

        $output->writeln('Will print using template: <info>' . $tplList[$tplIndex] . '</info>' . PHP_EOL);
    }
}
