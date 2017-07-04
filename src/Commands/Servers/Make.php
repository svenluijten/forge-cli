<?php

namespace Sven\ForgeCLI\Commands\Servers;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Make extends BaseCommand
{
    /**
     * @var array
     */
    protected $optionMap = [
        'provider' => 'provider',
        'credentials' => 'credential_id',
        'region' => 'region',
        'ip' => 'ip_address',
        'private-ip' => 'private_ip_address',
        'php' => 'php_version',
        'database' => 'database',
        'install-maria' => 'maria',
        'load-balancer' => 'load_balancer',
        'network' => 'network',
    ];

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('make:server')
            ->addOption('provider', null, InputOption::VALUE_REQUIRED, 'The provider to provision the server on. Can be either "ocean2", "linode", "aws", or "custom".', 'ocean2')
            ->addOption('credentials', 'C', InputOption::VALUE_REQUIRED, 'Credentials to use. Not required when using the "custom" provider.')
            ->addOption('region', null, InputOption::VALUE_REQUIRED, 'The region to provision the server in. Not required when using the "custom" provider.')
            ->addOption('ip', null, InputOption::VALUE_REQUIRED, 'IP address of the server. Required when using the "custom" provider.')
            ->addOption('private-ip', null, InputOption::VALUE_REQUIRED, 'Private IP address of the server. Required when using the "custom" provider.')
            ->addOption('php', null, InputOption::VALUE_REQUIRED, 'PHP version to install when provisioning the server. Supported versions are "php56", "php70", and "php71".')
            ->addOption('database', null, InputOption::VALUE_REQUIRED, 'The name of the database to create when provisioning the server.', 'forge')
            ->addOption('install-maria', null, InputOption::VALUE_NONE, 'Whether MariaDB should be installed. If left out, MySQL will be installed by default.')
            ->addOption('load-balancer', null, InputOption::VALUE_NONE, 'Whether the server should be provisioned as a load balancer.')
            ->addOption('network', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'Other servers\' ids this one can network with.')
            ->setDescription('Create a new server.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->forge->createServer(
            $this->fillData($input->getOptions())
        );
    }
}
