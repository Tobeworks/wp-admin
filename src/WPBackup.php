<?php

namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use App\WPCLI as WPCLI;

class WPBackup extends Command
{

    const WP = '/usr/local/bin/wp';

    protected static $defaultName = 'wp:backup';

    protected function configure(): void
    {
        $this->addArgument('path', InputArgument::REQUIRED, 'The path is required');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $this->wp = new WPCLI($input->getArgument('path'));
        $this->wp->dbExport();
        // $this->wp->exec('core check-update');
       // $output->writeln($this->wp->exec('core check-update'));
        return Command::SUCCESS;
    }
}
