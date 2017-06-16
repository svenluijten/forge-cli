<?php

namespace Sven\ForgeCLI\Commands\Workers;

use Themsaid\Forge\Resources\Worker;
use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class All extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('list:workers')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to list the workers for.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site the worker is on.')
            ->setDescription('Show all workers.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $rows = array_map(function (Worker $worker) {
            return [$worker->id, $worker->connection, $worker->status, $worker->createdAt];
        }, $this->forge->workers($input->getArgument('server'), $input->getArgument('site')));

        $this->table($output, ['Id', 'Connection', 'Status', 'Created'], $rows);
    }
}
