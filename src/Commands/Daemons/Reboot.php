<?php

namespace Sven\ForgeCLI\Commands\Daemons;

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
        $this->setName('reboot:daemon')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the daemon is on.')
            ->addArgument('daemon', InputArgument::REQUIRED, 'The id of the daemon to reboot.')
            ->addOption('force', null, InputOption::VALUE_NONE, 'If we want to execute without interaction')
            ->setDescription('Restart the given daemon on one of your servers.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $daemon = $input->getArgument('daemon');

        if (! $this->confirmToProceed("You are going to reboot the daemon with id {$daemon}.")) {
            return;
        }

        $this->forge->restartDaemon($input->getArgument('server'), $daemon);
    }
}
