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
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->wp = new WPCLI($input->getArgument('path'));
        $res = $this->wp->checkUpdate();
        if($res != ''){
            $output->writeln('Update needed: Going further with update to '. $res);
        }else{
            $output->writeln('No Update needed. Aborting');
        }
        return Command::SUCCESS;
    }
}