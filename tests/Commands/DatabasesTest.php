<?php

namespace Sven\ForgeCLI\Tests\Commands;

use Sven\ForgeCLI\Commands\Databases\Delete;
use Sven\ForgeCLI\Tests\TestCase;

class DatabasesTest extends TestCase
{
    /** @test */
    public function it_deletes_a_database()
    {
        $this->forge->shouldReceive()
            ->deleteMysqlDatabase('12345', '6789');

        $this->command(Delete::class)
            ->setInputs(['yes'])
            ->execute([
                'server' => '12345',
                'database' => '6789',
            ]);
    }

    /** @test */
    public function it_forces_deletition_of_a_database()
    {
        $this->forge->shouldReceive()
            ->deleteMysqlDatabase('12345', '6789');

        $this->command(Delete::class)
            ->execute([
                'server' => '12345',
                'database' => '6789',
                '--force' => true,
            ]);
    }

    /** @test */
    public function it_does_not_delete_a_database_if_no_is_answered()
    {
        $this->forge->shouldNotReceive()
            ->deleteMysqlDatabase();

        $tester = $this->command(Delete::class)->setInputs(['no']);

        $tester->execute([
            'server' => '12345',
            'database' => '6789',
        ]);

        $this->assertStringContainsString('Command Cancelled!', $tester->getDisplay());
    }
}
