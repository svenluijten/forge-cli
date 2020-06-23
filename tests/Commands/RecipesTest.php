<?php

namespace Sven\ForgeCLI\Tests\Commands;

use Sven\ForgeCLI\Commands\Recipes\Run;
use Sven\ForgeCLI\Tests\TestCase;

class RecipesTest extends TestCase
{
    public function test_it_runs_a_recipe()
    {
        $this->forge->shouldReceive('runRecipe')
            ->withArgs([1, [
                'servers' => [1],
            ]]);

        $tester = $this->command(Run::class);

        $tester->execute([
            '--server' => [1],
            'recipe' => '1',
        ]);
    }
}
