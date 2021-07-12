<?php

namespace Sven\ForgeCLI\Commands\Env;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Update extends BaseCommand implements NeedsForge
{
    /**
     * @var array
     */
    protected array $optionMap = [
        'file' => 'file',
    ];

    public function configure(): void
    {
        $this->setName('env:set')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site you want to update the .env file of.')
            ->addOption('file', null, InputOption::VALUE_REQUIRED, 'The path to your new .env file.')
            ->setDescription('Update the .env file of the given site.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->forge->updateSiteEnvironmentFile(
            $input->getArgument('server'), $input->getArgument('site'), $this->getFileContent($input, 'file')
        );

        return 0;
    }
}
