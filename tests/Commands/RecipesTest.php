<?php

namespace Sven\ForgeCLI\Tests\Commands;

use Sven\ForgeCLI\Commands\Recipes\Delete;
use Sven\ForgeCLI\Tests\TestCase;

class RecipesTest extends TestCase
{
    /** @test */
    public function it_deletes_a_recipe()
    {
        $this->forge->shouldReceive()
            ->deleteRecipe('12345');

        $this->command(Delete::class)
            ->setInputs(['yes'])
            ->execute([
                'recipe' => '12345',
            ]);
    }

    /** @test */
    public function it_forces_deletition_of_a_recipe()
    {
        $this->forge->shouldReceive()
            ->deleteRecipe('12345');

        $this->command(Delete::class)
            ->execute([
                'recipe' => '12345',
                '--force' => true,
            ]);
    }

    /** @test */
    public function it_does_not_delete_a_recipe_if_no_is_answered()
    {
        $this->forge->shouldNotReceive()
            ->deleteRecipe();

        $tester = $this->command(Delete::class)->setInputs(['no']);

        $tester->execute([
            'recipe' => '12345',
        ]);

        $this->assertStringContainsString('Command Cancelled!', $tester->getDisplay());
    }
}
