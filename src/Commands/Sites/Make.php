<?php

namespace Sven\ForgeCLI\Commands\Sites;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Make extends BaseCommand implements NeedsForge
{
    /**
     * @var array
     */
    protected $optionMap = [
        'domain' => 'domain',
        'type' => 'project_type',
        'directory' => 'directory',
        'alias' => 'aliases',
    ];

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('site:make')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to create a new site on.')
            ->addOption('domain', null, InputOption::VALUE_REQUIRED, 'The domain of your new site.')
            ->addOption('type', null, InputOption::VALUE_REQUIRED, 'The type of application to install on the site. Can be either "php", "html", "Symfony", or "symfony_dev".', 'php')
            ->addOption('directory', null, InputOption::VALUE_REQUIRED, 'The base directory of the site.', '/public')
            ->addOption('alias', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL, 'The aliases assigned to the site.')
            ->setDescription('Create a new site on one of your servers.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->forge->createSite(
            $input->getArgument('server'),
            $this->fillData($input->getOptions()),
            false
        );

        return 0;
    }
}
