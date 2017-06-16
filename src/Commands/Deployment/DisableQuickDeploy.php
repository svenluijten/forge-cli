<?php

namespace Sven\ForgeCLI\Commands\Deployment;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DisableQuickDeploy extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('disable:quickdeploy')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to disable quick deployment for.')
            ->setDescription('Disable quick deployment on the given site.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->forge->disableQuickDeploy(
            $input->getArgument('server'), $input->getArgument('site')
        );
    }
}
