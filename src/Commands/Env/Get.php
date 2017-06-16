<?php

namespace Sven\ForgeCLI\Commands\Env;

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
        $this->setName('get:env')
             ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to get the .env file for.')
             ->setDescription('Show the .env file.');
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $env = $this->forge->siteEnvironmentFile(
            $input->getArgument('server'), $input->getArgument('site')
        );

        $output->writeln($env);
    }
}
