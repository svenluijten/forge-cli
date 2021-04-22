<?php

namespace Sven\ForgeCLI\Commands\Certificates;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Laravel\Forge\Resources\Certificate;

class ListAll extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('certificate:list')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to list certificates for.')
            ->setDescription('Show all SSL certificates installed on the given site.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $certificates = $this->forge->certificates($input->getArgument('server'), $input->getArgument('site'));

        $this->table($output, ['Id', 'Status', 'Active', 'Created'], array_map(function (Certificate $certificate) {
            return [$certificate->id, $certificate->status, $certificate->active ? 'Yes' : 'No', $certificate->createdAt];
        }, $certificates));

        return 0;
    }
}
