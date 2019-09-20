<?php

namespace Sven\ForgeCLI\Commands\Sites;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Deploy extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('deploy:site')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site to deploy is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to deploy.')
            ->addOption('wait', null, InputOption::VALUE_NONE, 'If we should wait for execution')
            ->setDescription('Deploy the given website.');
    }

    public function initialize(InputInterface $input, OutputInterface $output)
    {
        // If the 'site' argument is present, the user probably did not
        // use an alias, so we will return early. If it is missing,
        // resolve the alias and set the arguments accordingly.
        if ($input->getArgument('site') !== null) {
            return;
        }

        $alias = $this->config->get(
            'aliases.'.$input->getArgument('server')
        );

        // No alias was found by that name, so we will
        // continue executing the command here. This
        // will cause a validation error later on.
        if ($alias === null) {
            $output->writeln("<error>No alias found for '{$input->getArgument('server')}'</error>");

            return;
        }

        // The alias is misconfigured, let the user know and continue executing the command.
        if (! isset($alias['server']) || ! isset($alias['site'])) {
            $output->writeln('<error>No server/site set!</error>');

            return;
        }

        if (! $output->isQuiet()) {
            $output->writeln("<comment>Using aliased server '{$alias['server']}' and site '{$alias['site']}'</comment>");
        }

        $input->setArgument('server', $alias['server']);
        $input->setArgument('site', $alias['site']);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->forge->deploySite(
            $input->getArgument('server'), $input->getArgument('site'), $input->getOption('wait')
        );
    }
}
