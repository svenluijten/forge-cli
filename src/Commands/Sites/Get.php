<?php

namespace Sven\ForgeCLI\Commands\Sites;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Get extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('show:site')
            ->setDescription('Show information about a site on a specified server.')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to show information about.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $site = $this->forge->site(
            $input->getArgument('server'), $input->getArgument('site')
        );

        $output->writeln([
            '<info>Name:</info>            ' . $site->name,
            '<info>Repository info:</info> ' . $site->repository . ' @ ' . $site->repositoryBranch,
            '<info>Directory:</info>       ' . $site->directory,
            '<info>Quick deploy:</info>    ' . ($site->quickDeploy ? 'On' : 'Off'),
            '<info>Status:</info>          ' . $site->status,
            '<info>Project type:</info>    ' . $site->projectType,
            '<info>Created:</info>         ' . $site->createdAt,
        ]);
    }
}
