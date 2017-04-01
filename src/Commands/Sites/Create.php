<?php

namespace Sven\ForgeCLI\Commands\Sites;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Create extends BaseCommand
{
    /**
     * @var array
     */
    protected $optionMap = [
        'domain' => 'domain',
        'type' => 'project_type',
        'directory' => 'directory',
    ];

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('create:site')
            ->setDescription('Create a new site on one of your servers.')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to create a new site on.')
            ->addOption('domain', null, InputOption::VALUE_REQUIRED, 'The domain of your new site')
            ->addOption('type', null, InputOption::VALUE_REQUIRED, 'The type of application to install on the site. Can be either "php", "html", "Symfony", or "symfony_dev".', 'php')
            ->addOption('directory', null, InputOption::VALUE_REQUIRED, 'The base directory of the site.', '/public');
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $this->forge->createSite(
            $input->getArgument('server'),
            $this->fillData($input->getOptions()),
            false
        );
    }
}
