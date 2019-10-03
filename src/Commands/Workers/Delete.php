<?php

namespace Sven\ForgeCLI\Commands\Workers;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Commands\ConfirmableTrait;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class Delete extends BaseCommand implements NeedsForge
{
    use ConfirmableTrait;
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('delete:worker')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the database is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site the worker to delete is on.')
            ->addArgument('worker', InputArgument::REQUIRED, 'The id of the worker to delete.')
            ->addOption('force', null, InputOption::VALUE_NONE, 'If we want to execute without interaction')
            ->setDescription('Delete the given worker.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $worker = $input->getArgument('worker');

        if (! $this->confirmToProceed("You are going to delete the worker with id {$worker}.")) {
            return;
        }

        $this->forge->deleteWorker(
            $input->getArgument('server'), $input->getArgument('site'), $worker
        );
    }
}
