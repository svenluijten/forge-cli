<?php

namespace Sven\ForgeCLI\Commands\SshKeys;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Make extends BaseCommand implements NeedsForge
{
    /**
     * @var array
     */
    protected $optionMap = [
        'name' => 'name',
    ];

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('make:key')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to create a new SSH key on.')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'The name of your new SSH key.')
            ->addOption('file', null, InputOption::VALUE_REQUIRED, 'The path to the SSH key to install on the server.')
            ->addOption('wait', null, InputOption::VALUE_NONE, 'If we should wait for execution')
            ->setDescription('Install a new SSH key on one of your servers.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $data = $this->fillData($input->getOptions());

        $data['key'] = $this->getFileContent($input, 'file');

        $this->forge->createSSHKey(
            $input->getArgument('server'),
            $data,
            $input->getOption('wait')
        );
    }
}
