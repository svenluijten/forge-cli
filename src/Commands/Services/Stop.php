<?php

namespace Sven\ForgeCLI\Commands\Services;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Stop extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('stop:service')
            ->setDescription('Stop a service on a server.')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to stop the service on.')
            ->addArgument('service', InputArgument::REQUIRED, 'The service to stop. Can be either "nginx", "mysql" or "postgres".');
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $service = strtolower($input->getArgument('service'));
        $server = $input->getArgument('server');

        switch ($service) {
            case 'mysql':
                $this->forge->stopMysql($server);
                break;
            case 'nginx':
                $this->forge->stopNginx($server);
                break;
            case 'postgres':
                $this->forge->stopPostgres($server);
                break;
        }
    }
}
