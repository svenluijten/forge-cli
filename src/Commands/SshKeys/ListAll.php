<?php

namespace Sven\ForgeCLI\Commands\SshKeys;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Themsaid\Forge\Resources\SSHKey;

class ListAll extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('key:list')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to list SSH keys for.')
            ->setDescription('Show all SSH keys installed on a server.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->table($output, ['Id', 'Name', 'Status', 'Created'], array_map(function (SSHKey $key) {
            return [$key->id, $key->name, $key->status, $key->createdAt];
        }, $this->forge->keys($input->getArgument('server'))));
    }
}
