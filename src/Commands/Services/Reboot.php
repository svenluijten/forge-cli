<?php

namespace Sven\ForgeCLI\Commands\Services;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Commands\ConfirmableTrait;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Reboot extends BaseCommand implements NeedsForge
{
    use ConfirmableTrait;

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('reboot:service')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to reboot the service on.')
            ->addArgument('service', InputArgument::REQUIRED, 'The service to reboot. Can be either "nginx", "mysql" or "postgres".')
            ->addOption('force', null, InputOption::VALUE_NONE, 'If we want to execute without interaction')
            ->setDescription('Reboot a service on a server.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $service = strtolower($input->getArgument('service'));
        $server = $input->getArgument('server');

        if (! $this->confirmToProceed("You are going to reboot {$service} on the server with id {$server}.")) {
            return;
        }

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
