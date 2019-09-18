<?php

namespace Sven\ForgeCLI\Commands\Sites;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Deploy extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('deploy:site')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site to deploy is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to deploy.')
            ->addOption('wait', null, InputOption::VALUE_OPTIONAL, 'Boolean if you want to wait for execution', false)
            ->setDescription('Deploy the given website.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->forge->deploySite(
            $input->getArgument('server'), $input->getArgument('site'), ($input->getOption('wait') !== false)
        );
    }
}
