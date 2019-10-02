<?php

namespace Sven\ForgeCLI\Commands\Projects;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallGit extends BaseCommand implements NeedsForge
{
    /**
     * @var array
     */
    protected $optionMap = [
        'provider' => 'provider',
        'repository' => 'repository',
        'branch' => 'branch',
    ];

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('install:git')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to install the git project on.')
            ->addOption('provider', null, InputOption::VALUE_REQUIRED, 'The provider to use. Must be either "github" or "custom".', 'github')
            ->addOption('repository', null, InputOption::VALUE_REQUIRED, 'The repository to install. Must be in the format "username/repository".')
            ->addOption('branch', null, InputOption::VALUE_OPTIONAL, 'The branch to install. Must be in the format "master".', 'master')
            ->addOption('wait', null, InputOption::VALUE_NONE, 'If we should wait for execution')
            ->setDescription('Install a new git project on a site.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->forge->installGitRepositoryOnSite(
            $input->getArgument('server'),
            $input->getArgument('site'),
            $this->fillData($input->getOptions()),
            $input->getOption('wait')
        );
    }
}
