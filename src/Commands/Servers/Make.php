<?php

namespace Sven\ForgeCLI\Commands\Servers;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Make extends BaseCommand implements NeedsForge
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
        'database-type' => 'database_type',
        'install-maria' => 'maria',
        'load-balancer' => 'load_balancer',
        'network' => 'network',
        'name' => 'name',
        'size' => 'size',
    ];

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('server:make')
            ->addOption('provider', null, InputOption::VALUE_REQUIRED, 'The provider to provision the server on. Can be either "ocean2", "linode", "aws", or "custom".', 'ocean2')
            ->addOption('credentials', 'C', InputOption::VALUE_REQUIRED, 'Credentials to use. Not required when using the "custom" provider.')
            ->addOption('region', null, InputOption::VALUE_REQUIRED, 'The region to provision the server in. Not required when using the "custom" provider.')
            ->addOption('ip', null, InputOption::VALUE_REQUIRED, 'IP address of the server. Required when using the "custom" provider.')
            ->addOption('private-ip', null, InputOption::VALUE_REQUIRED, 'Private IP address of the server. Required when using the "custom" provider.')
            ->addOption('php', null, InputOption::VALUE_REQUIRED, 'PHP version to install when provisioning the server. Supported versions are "php56", "php70", and "php71".')
            ->addOption('database', null, InputOption::VALUE_REQUIRED, 'The name of the database to create when provisioning the server.', 'forge')
            ->addOption('database-type', null, InputOption::VALUE_OPTIONAL, 'The type of DB to install. Can be "mariadb", "mysql", "mysql8, "postgres", or "none".', 'mysql')
            ->addOption('install-maria', null, InputOption::VALUE_NONE, 'Whether MariaDB should be installed. If left out, MySQL will be installed by default.')
            ->addOption('load-balancer', null, InputOption::VALUE_NONE, 'Whether the server should be provisioned as a load balancer.')
            ->addOption('network', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'Other servers\' ids this one can network with.')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'The name of the server.')
            ->addOption('size', null, InputOption::VALUE_REQUIRED, 'The size of the server.')
            ->setDescription('Create a new server.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $createServerRequest = $this->fillData($input->getOptions());

        if ($createServerRequest['database_type'] === 'none') {
            $createServerRequest['database_type'] = '';
        }

        $this->forge->createServer($createServerRequest);

        return 0;
    }
}
