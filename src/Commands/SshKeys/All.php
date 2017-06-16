<?php

namespace Sven\ForgeCLI\Commands\SshKeys;

use Themsaid\Forge\Resources\SSHKey;
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
        $this->setName('list:keys')
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
