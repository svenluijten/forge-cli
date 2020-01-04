<?php

namespace Sven\ForgeCLI\Commands\Sites;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Deploy extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('site:deploy')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site to deploy is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to deploy.')
            ->setDescription('Deploy the given website.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->forge->deploySite(
            $input->getArgument('server'), $input->getArgument('site')
        );
    }
}
