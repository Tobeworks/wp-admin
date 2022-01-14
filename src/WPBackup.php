<?php

namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use App\WPCLI as WPCLI;

class WPBackup extends Command
{
    protected static $defaultName = 'backup';

    protected function configure(): void
    {
        $this->addArgument('path', InputArgument::REQUIRED, 'The path is required')
        ->setDescription('Backup a Wordpress Installation and gzip it')
        ->addOption('transfer','t', InputOption::VALUE_NONE,'Transfer directly to FTP');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $transfer = $input->getOption('transfer');
        
        $this->wp = new WPCLI($input->getArgument('path'));
        $this->wp->export();
        $output->writeln('Export done');
        
        if($transfer == true){
            $output->writeln('Transfer started');

            $output->writeln('Transfer done');
        }
        return Command::SUCCESS;
    }
}
