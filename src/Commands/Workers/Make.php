<?php

namespace Sven\ForgeCLI\Commands\Workers;

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
        'connection' => 'connection',
        'timeout' => 'timeout',
        'sleep' => 'sleep',
        'tries' => 'tries',
        'daemon' => 'daemon',
    ];

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('make:worker')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to create the worker on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to install the worker on.')
            ->addOption('connection', null, InputOption::VALUE_REQUIRED, 'The connection to start the worker on.')
            ->addOption('timeout', null, InputOption::VALUE_REQUIRED, 'The timeout for the worker in seconds.', 90)
            ->addOption('sleep', null, InputOption::VALUE_REQUIRED, 'The time in seconds to sleep if the queue is empty.', 60)
            ->addOption('tries', null, InputOption::VALUE_REQUIRED, 'How often the worker should try processing a job.', null)
            ->addOption('daemon', null, InputOption::VALUE_NONE, 'Whether the worker should be installed as a daemon.')
            ->addOption('wait', null, InputOption::VALUE_NONE, 'If we should wait for execution')
            ->setDescription('Create a new worker.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->forge->createWorker(
            $input->getArgument('server'),
            $input->getArgument('site'),
            $this->fillData($input->getOptions()),
            $input->getOption('wait')
        );
    }
}
