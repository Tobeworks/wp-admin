<?php

namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

use App\WPCLI as WPCLI;
use App\DataSource as DataSource;
use App\Transfer as Transfer;

class WPBackupSource extends Command
{
    protected static $defaultName = 'backupsource';

    protected function configure(): void
    {
        //$this->addArgument('source', InputArgument::OPTIONAL, 'The source is required');
        $this->setDescription('Backup Source Files via CSV')
        ->addOption('transfer', 't', InputOption::VALUE_NONE, 'Transfer directly to FTP Server');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $datasource = new DataSource();
        $sources = $datasource->getSources();
        $transferOption = $input->getOption('transfer');


        for($i=0; $i<count($sources); $i++){
            $output->writeln($sources[$i]);
            $wp = new WPCLI($sources[$i]);
            $wp->export();
            $output->writeln($sources[$i].' done');

            if ($transferOption == true) {

                $transfer = new Transfer();
                $output->writeln('Transfer started');
                $transfer->putSingle(trim($wp->getDomainDir()));
                $output->writeln('Transfer done');
                unset($transfer);
            }

            unset($wp);
        }
        return Command::SUCCESS;
    }
}
