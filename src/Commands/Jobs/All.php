<?php

namespace Sven\ForgeCLI\Commands\Jobs;

use Themsaid\Forge\Resources\Job;
use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class All extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('list:jobs')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to list the jobs for.')
            ->setDescription('Show all jobs configured on a server.');
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $this->table($output, ['Id', 'Command', 'User', 'Frequency', 'Created'], array_map(function (Job $job) {
            return [$job->id, $job->name, $job->user, $job->frequency, $job->createdAt];
        }, $this->forge->jobs($input->getArgument('server'))));
    }
}
