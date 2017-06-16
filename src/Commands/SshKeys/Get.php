<?php

namespace Sven\ForgeCLI\Commands\SshKeys;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Get extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('show:key')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the SSH key is on.')
            ->addArgument('key', InputArgument::REQUIRED, 'The id of the SSH key to show information about.')
            ->setDescription('Show information about an SSH key on a specified server.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $key = $this->forge->SSHKey(
            $input->getArgument('server'), $input->getArgument('key')
        );

        $output->writeln([
            '<info>Name:</info>    '.$key->name,
            '<info>Status:</info>  '.$key->status,
            '<info>Created:</info> '.$key->createdAt,
        ]);
    }
}
