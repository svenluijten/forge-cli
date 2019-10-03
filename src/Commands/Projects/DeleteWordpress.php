<?php

namespace Sven\ForgeCLI\Commands\Projects;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Commands\ConfirmableTrait;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteWordpress extends BaseCommand implements NeedsForge
{
    use ConfirmableTrait;
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('delete:wordpress')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to delete the WordPress project from.')
            ->addOption('force', null, InputOption::VALUE_NONE, 'If we want to execute without interaction')
            ->setDescription('Delete a WordPress project from a site.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $site = $input->getArgument('site');

        if (! $this->confirmToProceed("You are going to delete the WordPress project from the server with id {$site}.")) {
            return;
        }

        $this->forge->removeWordPress($input->getArgument('server'), $site);
    }
}
