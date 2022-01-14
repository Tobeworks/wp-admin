<?php
namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


use App\Config as Config;
use App\Transfer as Transfer;


class WPTransfer extends Command
{
    protected $transfer;
    protected static $defaultName = 'transfer';


    protected function configure(): void
    {
        $this->setDescription('Transfer ALL uploaded files to FTP storage');
        $config = new Config();
        $this->config = $config->getConfig();

        $this->transfer = new Transfer();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->transfer->putAll();
        $output->writeln('-End-');
        return Command::SUCCESS;
    }
}