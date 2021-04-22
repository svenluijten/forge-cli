<?php

namespace Sven\ForgeCLI\Commands\Daemons;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Laravel\Forge\Resources\Daemon;

class ListAll extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('daemon:list')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to list the daemons for.')
            ->setDescription('Show all daemons running on a server.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $rows = array_map(function (Daemon $daemon) {
            return [$daemon->id, $daemon->status, $daemon->command, $daemon->createdAt];
        }, $this->forge->daemons($input->getArgument('server')));

        $this->table($output, ['Id', 'Status', 'Command', 'Created'], $rows);

        return 0;
    }
}
