<?php

namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use App\WPCLI as WPCLI;

class WPUpdate extends Command
{

    protected static $defaultName = 'update';

    protected function configure(): void
    {
        $this->addArgument('path', InputArgument::REQUIRED, 'The path is required');
        $this->setDescription('Core-Update');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->wp = new WPCLI($input->getArgument('path'));
        $res = $this->wp->checkUpdate();
        if ($res != '') {
            $output->writeln('Update needed: Going further with update to ' . $res);
            $output->writeln($this->wp->CoreUpdate());
        } else {
            $output->writeln('No Core Update needed.');
        }
        $output->writeln('Plugin Updates start');
        $output->writeln($this->wp->PluginsUpdate());
        $output->writeln($this->wp->ThemesUpdate());
        $output->writeln('-End-');
        return Command::SUCCESS;
    }
}
