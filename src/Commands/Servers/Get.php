<?php

namespace Sven\ForgeCLI\Commands\Servers;

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
        $this->setName('show:server')
            ->setDescription('Show information about one of your servers.')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to show information about.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $server = $this->forge->server($input->getArgument('server'));

        $output->writeln([
            '<info>Name:</info>        ' . $server->name,
            '<info>IP Address:</info>  ' . $server->ipAddress,
            '<info>Size:</info>        ' . $server->size,
            '<info>Region:</info>      ' . $server->region,
            '<info>PHP version:</info> ' . $server->phpVersion,
            '<info>Created:</info>     ' . $server->createdAt,
        ]);
    }
}
