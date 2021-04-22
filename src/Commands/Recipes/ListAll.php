<?php

namespace Sven\ForgeCLI\Commands\Recipes;

use Laravel\Forge\Resources\Recipe;
use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListAll extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('recipe:list')
            ->setDescription('Show all recipes in your Forge account.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->table($output, ['Id', 'Command', 'User', 'Created'], array_map(function (Recipe $recipe) {
            return [$recipe->id, $recipe->name, $recipe->user, $recipe->createdAt];
        }, $this->forge->recipes()));

        return 0;
    }
}
