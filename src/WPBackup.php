<?php

namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use App\WPCLI as WPCLI;
//use App\Config as Config;
use App\Transfer as Transfer;

class WPBackup extends Command
{
    protected static $defaultName = 'backup';

    protected function configure(): void
    {
        $this->addArgument('path', InputArgument::REQUIRED, 'The path is required')
        ->setDescription('Backup a Wordpress Installation and gzip it')
        ->addOption('transfer','t', InputOption::VALUE_NONE,'Transfer directly to FTP Server');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $transferOption = $input->getOption('transfer');
        
        $this->wp = new WPCLI($input->getArgument('path'));
        $this->wp->export();
        $output->writeln('Export done');
        
        if($transferOption == true){
            
            $transfer = new Transfer();
            $output->writeln('Transfer started');
            $transfer->putSingle(trim($this->wp->getDomainDir()));
            $output->writeln('Transfer done');
        }
        return Command::SUCCESS;
    }
}
