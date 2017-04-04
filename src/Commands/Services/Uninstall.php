<?php

namespace Sven\ForgeCLI\Commands\Services;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Uninstall extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('uninstall:service')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to uninstall the service from.')
            ->addArgument('service', InputArgument::REQUIRED, 'The service to be uninstalled. Can be "blackfire" or "papertrail".')
            ->setDescription('Uninstall a service from a server.');
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $server = $input->getArgument('server');

        switch (strtolower($input->getArgument('service'))) {
            case 'blackfire':
                $this->forge->removeBlackfire($server);
                break;

            case 'papertrail':
                $this->forge->removePapertrail($server);
                break;
        }
    }
}
