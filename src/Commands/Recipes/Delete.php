<?php

namespace Sven\ForgeCLI\Commands\Recipes;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Commands\ConfirmableTrait;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Delete extends BaseCommand implements NeedsForge
{
    use ConfirmableTrait;

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('delete:recipe')
            ->addArgument('recipe', InputArgument::REQUIRED, 'The id of the recipe to delete.')
            ->addOption('force', null, InputOption::VALUE_NONE, 'If we want to execute without interaction')
            ->setDescription('Delete one of your recipes.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $recipe = $input->getArgument('recipe');

        if (! $this->confirmToProceed("You are going to delete the recipe with id {$recipe}.")) {
            return;
        }

        $this->forge->deleteRecipe($recipe);
    }
}
