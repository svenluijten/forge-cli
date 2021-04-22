<?php

namespace Sven\ForgeCLI\Commands\Workers;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Laravel\Forge\Resources\Worker;

class ListAll extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('worker:list')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to list the workers for.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site the worker is on.')
            ->setDescription('Show all workers.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $rows = array_map(function (Worker $worker) {
            return [$worker->id, $worker->connection, $worker->status, $worker->createdAt];
        }, $this->forge->workers($input->getArgument('server'), $input->getArgument('site')));

        $this->table($output, ['Id', 'Connection', 'Status', 'Created'], $rows);

        return 0;
    }
}
