<?php

namespace Sven\ForgeCLI\Commands\NginxConfig;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Get extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('get:nginx-config')
             ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to get the config script for.')
             ->setDescription('Show the nginx configuration file.');
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $config = $this->forge->siteNginxFile(
            $input->getArgument('server'), $input->getArgument('site')
        );

        $output->writeln($config);
    }
}
