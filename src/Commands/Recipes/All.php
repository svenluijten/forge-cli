<?php

namespace Sven\ForgeCLI\Commands\Recipes;

use Themsaid\Forge\Resources\Recipe;
use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class All extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('list:recipes')
            ->setDescription('Show all recipes in your Forge account.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->table($output, ['Id', 'Command', 'User', 'Created'], array_map(function (Recipe $recipe) {
            return [$recipe->id, $recipe->name, $recipe->user, $recipe->createdAt];
        }, $this->forge->recipes()));
    }
}
