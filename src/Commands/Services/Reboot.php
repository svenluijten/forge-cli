<?php

namespace Sven\ForgeCLI\Commands\Services;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Reboot extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('reboot:service')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to reboot the service on.')
            ->addArgument('service', InputArgument::REQUIRED, 'The service to reboot. Can be either "nginx", "mysql" or "postgres".')
            ->setDescription('Reboot a service on a server.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $service = strtolower($input->getArgument('service'));
        $server = $input->getArgument('server');

        switch ($service) {
            case 'mysql':
                $this->forge->rebootMysql($server);
                break;
            case 'nginx':
                $this->forge->rebootNginx($server);
                break;
            case 'postgres':
                $this->forge->rebootPostgres($server);
                break;
        }
    }
}
