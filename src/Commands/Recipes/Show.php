<?php

namespace Sven\ForgeCLI\Commands\Recipes;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Show extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('show:recipe')
            ->addArgument('recipe', InputArgument::REQUIRED, 'The id of the recipe to show information about.')
            ->setDescription('Show information about a recipe.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $recipe = $this->forge->recipe(
            $input->getArgument('recipe')
        );

        $output->writeln([
            '<info>Name:</info>    '.$recipe->name,
            '<info>User:</info>    '.$recipe->user,
            '<info>Created:</info> '.$recipe->createdAt,
        ]);
    }
}
