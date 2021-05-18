<?php

namespace Sven\ForgeCLI\Commands\Recipes;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class Delete extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('recipe:delete')
            ->addArgument('recipe', InputArgument::REQUIRED, 'The id of the recipe to delete.')
            ->setDescription('Delete one of your recipes.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $recipe = $input->getArgument('recipe');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you want to delete the recipe with id "'.$recipe.'"?', false);

        if (!$helper->ask($input, $output, $question)) {
            $output->writeln('<info>Ok, aborting. Your recipe is safe.</info>');
        } else {
            $this->forge->deleteRecipe($recipe);
        }

        return 0;
    }
}
