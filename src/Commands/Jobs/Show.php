<?php

namespace Sven\ForgeCLI\Commands\Jobs;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Show extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('job:show')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the scheduled job is on.')
            ->addArgument('job', InputArgument::REQUIRED, 'The id of the scheduled job to show information about.')
            ->setDescription('Show information about a scheduled job on a specified server.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $job = $this->forge->job(
            $input->getArgument('server'), $input->getArgument('job')
        );

        $output->writeln([
            '<info>Command:</info>   '.$job->name,
            '<info>Frequency:</info> '.$job->frequency,
            '<info>Cron:</info>      '.$job->cron,
            '<info>User:</info>      '.$job->user,
            '<info>Status:</info>    '.$job->status,
            '<info>Created:</info>   '.$job->createdAt,
        ]);

        return 0;
    }
}
