<?php

namespace Sven\ForgeCLI\Commands\Jobs;

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
        'command' => 'command',
        'frequency' => 'frequency',
        'minute' => 'minute',
        'hour' => 'hour',
        'day' => 'day',
        'month' => 'month',
        'weekday' => 'weekday',
    ];

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('make:job')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to schedule a new job for.')
            ->addOption('command', null, InputOption::VALUE_REQUIRED, 'The command to schedule.')
            ->addOption('frequency', null, InputOption::VALUE_REQUIRED, 'With what frequency should the command run? Valid values are "minutely", "hourly", "nightly", "weekly", "monthly", and "custom".', 'custom')
            ->addOption('minute', null, InputOption::VALUE_REQUIRED, 'The minute to run the scheduled job on. Only required when using the "custom" frequency.', '*')
            ->addOption('hour', null, InputOption::VALUE_REQUIRED, 'The hour to run the scheduled job on. Only required when using the "custom" frequency.', '*')
            ->addOption('day', null, InputOption::VALUE_REQUIRED, 'The day to run the scheduled job on. Only required when using the "custom" frequency.', '*')
            ->addOption('month', null, InputOption::VALUE_REQUIRED, 'The month to run the scheduled job on. Only required when using the "custom" frequency.', '*')
            ->addOption('weekday', null, InputOption::VALUE_REQUIRED, 'The weekday to run the scheduled job on. Only required when using the "custom" frequency.', '*')
            ->addOption('wait', null, InputOption::VALUE_NONE, 'If we should wait for execution')
            ->setDescription('Schedule a new job on one of your servers.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (strtolower($input->getOption('frequency')) !== 'custom') {
            $this->requireOptions($input, 'minute', 'hour', 'day', 'month', 'weekday');
        }

        $this->forge->createJob(
            $input->getArgument('server'),
            $this->fillData($input->getOptions()),
            $input->getOption('wait')
        );
    }
}
