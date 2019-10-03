<?php

namespace Sven\ForgeCLI\Commands\Jobs;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Commands\ConfirmableTrait;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Delete extends BaseCommand implements NeedsForge
{
    use ConfirmableTrait;

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('delete:job')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server where the site is.')
            ->addArgument('job', InputArgument::REQUIRED, 'The id of the job to delete.')
            ->addOption('force', null, InputOption::VALUE_NONE, 'If we want to execute without interaction')
            ->setDescription('Delete a scheduled job.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $job = $input->getArgument('job');

        if (! $this->confirmToProceed("You are going to delete the scheduled job with id {$job}.")) {
            return;
        }

        $this->forge->deleteJob($input->getArgument('server'), $job);
    }
}
