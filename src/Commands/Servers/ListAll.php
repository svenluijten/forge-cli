<?php

namespace Sven\ForgeCLI\Commands\Servers;

use Laravel\Forge\Resources\Server;
use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListAll extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('server:list')
            ->setDescription('Show all servers associated with your account.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $rows = array_map(function (Server $server) {
            return [$server->name, $server->id, $server->ipAddress, $server->region, $server->isReady ? 'Yes' : 'No'];
        }, $this->forge->servers());

        $this->table($output, ['Name', 'Id', 'IP Address', 'Region', 'Ready'], $rows);

        return 0;
    }
}
