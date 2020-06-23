<?php

namespace Sven\ForgeCLI\Commands\Recipes;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Run extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('recipe:run')
            ->addArgument('recipe', InputArgument::REQUIRED, 'The id of the recipe to run.')
            ->addOption('server', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'The id of the server(s) to run the recipe on.')
            ->setDescription('Run one of your recipes.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->forge->runRecipe(
            $input->getArgument('recipe'), [
                'servers' => $input->getOption('server'),
            ]
        );

        return 0;
    }
}
