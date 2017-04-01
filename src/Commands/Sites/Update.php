<?php

namespace Sven\ForgeCLI\Commands\Sites;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Update extends BaseCommand
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
            ->setDescription('Update a site on a specified server.')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the server to update.')
            ->addOption('directory', null, InputOption::VALUE_REQUIRED, 'The new base directory of the website.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $this->forge->updateSite(
            $input->getArgument('server'), $input->getArgument('site'), $this->fillData($input->getOptions())
        );
    }
}
