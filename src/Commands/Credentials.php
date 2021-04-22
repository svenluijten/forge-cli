<?php

namespace Sven\ForgeCLI\Commands;

use Laravel\Forge\Resources\Credential;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Credentials extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('credentials')
            ->setDescription('Show all credentials associated with your account.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->table($output, ['Id', 'Name', 'Type'], array_map(function (Credential $credential) {
            return [$credential->id, $credential->name, $credential->type];
        }, $this->forge->credentials()));

        return 0;
    }
}
