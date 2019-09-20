<?php

namespace Sven\ForgeCLI\Commands\Services;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Install extends BaseCommand implements NeedsForge
{
    /**
     * @var array
     */
    protected $blackfireMap = [
        'server-id' => 'server_id',
        'server-token' => 'server_token',
    ];

    /**
     * @var array
     */
    protected $papertrailMap = [
        'host' => 'host',
    ];

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('install:service')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to install the service on.')
            ->addArgument('service', InputArgument::REQUIRED, 'The service to be installed. Can be "blackfire" or "papertrail".')
            ->addOption('server-id', null, InputOption::VALUE_REQUIRED, 'Blackfire\'s server id. Only required when installing Blackfire.')
            ->addOption('server-token', null, InputOption::VALUE_REQUIRED, 'Blackfire\'s server token. Only required when installing Blackfire.')
            ->addOption('host', null, InputOption::VALUE_REQUIRED, 'Papertrail\'s host option. Only required when installing Papertrail.')
            ->setDescription('Install a service on a server.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $service = strtolower($input->getArgument('service'));
        $server = $input->getArgument('server');
        $options = $input->getOptions();

        switch ($service) {
            case 'blackfire':
                $this->forge->installBlackfire($server, $this->fillData($options, $this->blackfireMap));
                break;

            case 'papertrail':
                $this->forge->installPapertrail($server, $this->fillData($options, $this->papertrailMap));
                break;
        }
    }
}
