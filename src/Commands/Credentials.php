<?php

namespace Sven\ForgeCLI\Commands;

use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Themsaid\Forge\Resources\Credential;

class Credentials extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('credentials')
            ->setDescription('Show all credentials associated with your account.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->table($output, ['Id', 'Name', 'Type'], array_map(function (Credential $credential) {
            return [$credential->id, $credential->name, $credential->type];
        }, $this->forge->credentials()));
    }
}
