<?php

namespace Sven\ForgeCLI\Commands\Certificates;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Make extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('make:certificate')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to make the SSL certificate for.')
            ->addOption('domain', null, InputOption::VALUE_REQUIRED, 'The domain to create an SSL certificate for.')
            ->addOption('country', null, InputOption::VALUE_REQUIRED, 'The country you currently live in.')
            ->addOption('state', null, InputOption::VALUE_REQUIRED, 'The state you currently live in.')
            ->addOption('city', null, InputOption::VALUE_REQUIRED, 'The city you currently live in.')
            ->addOption('organization', null, InputOption::VALUE_REQUIRED, 'The organization the SSL certificate should be issued to.')
            ->addOption('department', null, InputOption::VALUE_REQUIRED, 'The department you work in.')
            ->addOption('wait', null, InputOption::VALUE_NONE, 'If we should wait for execution')
            ->setDescription('Create a new SSL certificate.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->requireOptions($input, 'domain', 'country', 'state', 'city', 'organization', 'department');

        $certificate = $this->forge->createCertificate(
            $input->getArgument('server'),
            $input->getArgument('site'),
            $this->fillData($input->getOptions()),
            $input->getOption('wait')
        );

        $output->writeln([
            '<info>Domain:</info>            '.$certificate->domain,
            '<info>Status:</info>            '.$certificate->status,
            '<info>Exists:</info>            '.$certificate->existing ? 'Yes' : 'No',
            '<info>Activation Status:</info> '.$certificate->activationStatus,
            '<info>Created:</info>           '.$certificate->createdAt,
        ]);
    }
}
