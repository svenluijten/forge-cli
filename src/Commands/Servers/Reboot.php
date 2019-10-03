<?php

namespace Sven\ForgeCLI\Commands\Servers;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Commands\ConfirmableTrait;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Reboot extends BaseCommand implements NeedsForge
{
    use ConfirmableTrait;


    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('reboot:server')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to reboot.')
            ->addOption('force', null, InputOption::VALUE_NONE, 'If we want to execute without interaction')
            ->setDescription('Reboot one of your servers.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $server = $input->getArgument('server');

        if (! $this->confirmToProceed("You are going to reboot the server with id {$server}.")) {
            return;
        }

        $this->forge->rebootServer($server);
    }
}
