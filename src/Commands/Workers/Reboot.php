<?php

namespace Sven\ForgeCLI\Commands\Workers;

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
        $this->setName('reboot:worker')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the worker to reboot is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site the worker to reboot is on.')
            ->addArgument('worker', InputArgument::REQUIRED, 'The id of the worker to reboot.')
            ->addOption('force', null, InputOption::VALUE_NONE, 'If we want to execute without interaction')
            ->setDescription('Reboot one of your workers.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $worker = $input->getArgument('worker');

        if (! $this->confirmToProceed("You are going to reboot the worker with id {$worker}.")) {
            return;
        }

        $this->forge->restartWorker(
            $input->getArgument('server'), $input->getArgument('site'), $worker, false
        );
    }
}
