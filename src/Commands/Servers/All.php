<?php

namespace Sven\ForgeCLI\Commands\Servers;

use Themsaid\Forge\Resources\Server;
use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class All extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('list:servers')
            ->setDescription('Show all servers associated with your account.');
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $rows = array_map(function (Server $server) {
            return [$server->name, $server->id, $server->ipAddress, $server->region, $server->isReady ? 'Yes' : 'No'];
        }, $this->forge->servers());

        $this->table($output, ['Name', 'Id', 'IP address', 'Region', 'Ready'], $rows);
    }
}
