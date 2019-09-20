<?php

namespace Sven\ForgeCLI\Commands\Sites;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Update extends BaseCommand implements NeedsForge
{
    /**
     * @var array
     */
    protected $optionMap = [
        'directory' => 'directory',
    ];

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('update:site')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the server to update.')
            ->addOption('directory', null, InputOption::VALUE_REQUIRED, 'The new base directory of the website.')
            ->setDescription('Update a site on a specified server.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->forge->updateSite(
            $input->getArgument('server'), $input->getArgument('site'), $this->fillData($input->getOptions())
        );
    }
}
