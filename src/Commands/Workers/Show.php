<?php

namespace Sven\ForgeCLI\Commands\Workers;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Show extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('worker:show')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to the database is running on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site the worker is running on.')
            ->addArgument('worker', InputArgument::REQUIRED, 'The id of the worker to show information about.')
            ->setDescription('Show information about the given worker.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $worker = $this->forge->worker(
            $input->getArgument('server'), $input->getArgument('site'), $input->getArgument('worker')
        );

        $output->writeln([
            '<info>Status:</info>     '.$worker->status,
            '<info>Connection:</info> '.$worker->connection,
            '<info>Timeout:</info>    '.$worker->timeout,
            '<info>Command:</info>    '.$worker->command,
            '<info>Daemon:</info>     '.$worker->daemon ? 'Yes' : 'No',
            '<info>Created:</info>    '.$worker->createdAt,
        ]);

        return 0;
    }
}
