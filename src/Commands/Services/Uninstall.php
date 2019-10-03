<?php

namespace Sven\ForgeCLI\Commands\Services;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Commands\ConfirmableTrait;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Uninstall extends BaseCommand implements NeedsForge
{
    use ConfirmableTrait;
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('uninstall:service')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to uninstall the service from.')
            ->addArgument('service', InputArgument::REQUIRED, 'The service to be uninstalled. Can be "blackfire" or "papertrail".')
            ->addOption('force', null, InputOption::VALUE_NONE, 'If we want to execute without interaction')
            ->setDescription('Uninstall a service from a server.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $server = $input->getArgument('server');
        $service = strtolower($input->getArgument('service'));

        if (! $this->confirmToProceed("You are going to uninstall {$service} the server with id {$server}.")) {
            return;
        }

        switch ($service) {
            case 'blackfire':
                $this->forge->removeBlackfire($server);
                break;

            case 'papertrail':
                $this->forge->removePapertrail($server);
                break;
        }
    }
}
