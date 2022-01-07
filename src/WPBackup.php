<?php

namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use App\WPCLI as WPCLI;

class WPBackup extends Command
{
    protected static $defaultName = 'backup';

    protected function configure(): void
    {
        $this->addArgument('path', InputArgument::REQUIRED, 'The path is required');
        $this->setDescription('Backup a Wordpress Installation and gzip it');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $this->wp = new WPCLI($input->getArgument('path'));
        $this->wp->export();
        $output->writeln('Done!');
        return Command::SUCCESS;
    }
}
