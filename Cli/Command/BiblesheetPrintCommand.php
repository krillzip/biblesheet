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
        $meta = $sheet->metaSelectedSheet();
                
         if($meta === false){
             $output->writeln('<comment>No meta information extracted</comment>');
         }
        //var_dump($sheet->worksheetWalk());

        /* switch ($input->getArgument('list')) {
          case 'all':
          $data = $d->getModules();
          if ($r) {
          $output->write($data, false, OutputInterface::OUTPUT_RAW);
          } else {
          $structure = OutputParser::parseModules($data);
          $this->printStructure($structure, $output);
          }
          break;
          case 'modules':
          $data = $d->getModuleList();
          if ($r) {
          $output->write($data, false, OutputInterface::OUTPUT_RAW);
          } else {
          $structure = OutputParser::parseModuleList($data);
          $this->printListAsMatrix($structure, $output);
          }
          break;
          case 'bible':
          case 'bibles':
          $data = $d->getModules();
          $structure = OutputParser::parseModules($data);
          $output->writeln('<comment>Biblical Texts:</comment>');
          $this->printList($structure['Biblical Texts'], $output);
          break;
          case 'dictionary':
          case 'dictionaries':
          $data = $d->getModules();
          $structure = OutputParser::parseModules($data);
          $output->writeln('<comment>Dictionaries:</comment>');
          $this->printList($structure['Dictionaries'], $output);
          break;
          case 'commentary':
          case 'commentaries':
          $data = $d->getModules();
          $structure = OutputParser::parseModules($data);
          $output->writeln('<comment>Commentaries:</comment>');
          $this->printList($structure['Commentaries'], $output);
          break;
          case 'book':
          case 'books':
          $data = $d->getModules();
          $structure = OutputParser::parseModules($data);
          $output->writeln('<comment>Generic books:</comment>');
          $this->printList($structure['Generic books'], $output);
          break;
          case 'locale':
          case 'locales':
          $data = $d->getLocales();
          if ($r) {
          $output->write($data, false, OutputInterface::OUTPUT_RAW);
          } else {
          $structure = OutputParser::parseModuleList($data);
          $this->printListAsMatrix($structure, $output);
          }
          break;
          } */
    }

    /*    protected function getLongestName(array $names) {
      if (!empty($names)) {
      return max(array_map('strlen', $names)) + 1;
      } else {
      return 0;
      }
      }

      protected function printStructure(array $structure, OutputInterface $output) {
      foreach ($structure as $name => $section) {
      $output->writeln('<comment>' . $name . ':</comment>');
      if(!empty($section)){
      $this->printList($section, $output);
      }else{
      $output->writeln('   <error>No entries</error>');
      }
      }
      }

      protected function printList(array $list, OutputInterface $output) {
      $longest = $this->getLongestName(array_keys($list));
      foreach ($list as $abbr => $description) {
      $output->writeln('    <info>' . $abbr . '</info>' . str_pad(' ', $longest - strlen($abbr)) . '- ' . $description);
      }
      }

      protected function printListAsMatrix(array $list, OutputInterface $output) {
      $longest = $this->getLongestName($list);
      $dim = $this->getApplication()->getTerminalDimensions();
      $rowMax = (int)($dim[0] / $longest);

      if($rowMax < 1){
      $rowMax = 1;
      }

      while(count($list) > 0){
      $row = '';
      for($i = 0; $i < $rowMax; $i++){
      $abbr = array_shift($list);
      $row .= $abbr.str_pad(' ', $longest - strlen($abbr));
      }
      $output->writeln($row);
      }
      } */
}
