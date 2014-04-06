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
        $biblesheet = $this->getHelper('biblesheet')->get();
        $diatheke = $this->getHelper('diatheke')->get();
        $dialog = $this->getHelper('dialog');

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

        if ($meta === false) {
            $output->writeln('<comment>No meta information extracted</comment>');
        }

        $collection = $biblesheet->walkSheet($sheet, ($meta !== false) ? $meta : null)->flattenData();

        // Check witch template to print with
        $tplList = $tpl->getList();
        if (!empty($template)) {
            if (in_array($template, $tplList)) {
                $tplIndex = array_keys($tplList, $template, true);
            } else {
                $output->writeln('<error>Template: ' . $template . ' doesn\'t exist.</error>');
            }
        } else {
            $tplIndex = $dialog->select(
                    $output, 'Select template to use:' . PHP_EOL . '(<comment>Defaults to basic</comment>)', $tplList, 0
            );
        }

        $output->writeln('Will print using template: <info>' . $tplList[$tplIndex] . '</info>' . PHP_EOL);

        // Populating collection

        $progress = $this->getHelper('progress');
        $progress->start($output, count($collection) * 2);

        $diatheke->configure($biblesheet->getDiathekeConfiguration());
        foreach ($collection as $index => $reference) {
            $reference->verseCollection = $diatheke->bibleText($reference->reference);
            $progress->advance();
            $reference->book = $diatheke->bibleBook($reference->reference);
            $progress->advance();
            if ($reference->book == null) {
                $output->writeln(' <error>Invalid reference: ' . $reference->reference . '</error>');
            }
        }
        $progress->finish();

        ob_start();
        $tpl->render(
                $tplList[$tplIndex], ($meta !== false) ? $meta->getSettings() : array(), ($meta !== false) ? $meta->getVariables() : array(), $collection
        );
        $view = ob_get_contents();
        ob_end_clean();

        $texFile = dirname($file) . '/' . basename(strstr(substr($file, strrpos($file, '/') + 1), '.', true)) . '.tex';
        file_put_contents($texFile, $view);

        // Execute the latex generator
        exec('type rubber', $cOutput, $returnVal);
        if ($returnVal === 0) {
            $output->writeln('Latex is installed on this system.');
            if ($dialog->select($output, 'Do you want to generate a pdf?', array('y', 'n')) == 0) {
                system('rubber -d ' . $texFile);
            }
        }
    }

}
