<?php

namespace Sven\ForgeCLI\Tests\Commands;

use Sven\ForgeCLI\Commands\MysqlUsers\Delete;
use Sven\ForgeCLI\Commands\MysqlUsers\ListAll;
use Sven\ForgeCLI\Commands\MysqlUsers\Make;
use Sven\ForgeCLI\Commands\MysqlUsers\Show;
use Sven\ForgeCLI\Commands\MysqlUsers\Update;
use Sven\ForgeCLI\Tests\TestCase;
use Themsaid\Forge\Resources\MysqlUser;

class MysqlUsersTest extends TestCase
{
    /** @test */
    public function it_lists_all_mysql_users_on_a_server()
    {
        $this->forge->shouldReceive()
            ->mysqlUsers('12345')
            ->once()
            ->andReturn([
                new MysqlUser([
                    'id' => '::id::',
                    'serverId' => '12345',
                    'name' => '::name::',
                    'status' => '::status::',
                    'createdAt' => '::created-at::',
                ]),
            ]);

        $tester = $this->command(ListAll::class);

        $tester->execute([
            'server' => '12345',
        ]);

        $output = $tester->getDisplay();

        $this->assertStringContainsString('::id::', $output);
        $this->assertStringContainsString('::name::', $output);
        $this->assertStringContainsString('::status::', $output);
        $this->assertStringContainsString('::created-at::', $output);
    }

    /** @test */
    public function it_deletes_a_mysql_user()
    {
        $this->forge->shouldReceive()
            ->deleteMysqlUser('12345', '67890');

        $this->command(Delete::class)
            ->setInputs(['yes'])
            ->execute([
                'server' => '12345',
                'user' => '67890',
            ]);
    }

    /** @test */
    public function it_does_not_delete_the_mysql_user_if_no_is_answered()
    {
        $this->forge->shouldNotReceive()
            ->deleteMysqlUser();

        $this->command(Delete::class)
            ->setInputs(['no'])
            ->execute([
                'server' => '12345',
                'user' => '67890',
            ]);
    }

    /** @test */
    public function it_makes_a_mysql_user()
    {
        $this->forge->shouldReceive()
            ->createMysqlUser('12345', [
                'name' => '::username::',
                'password' => '::password::',
                'databases' => [1, 2, 3],
            ]);

        $this->command(Make::class)->execute([
            'server' => '12345',
            '--username' => '::username::',
            '--password' => '::password::',
            '--database' => [1, 2, 3],
        ]);
    }

    /** @test */
    public function it_updates_a_mysql_user()
    {
        $this->forge->shouldReceive()
            ->updateMysqlUser('12345', '67890', [
                'databases' => [4, 5, 6],
            ]);

        $this->command(Update::class)->execute([
            'server' => '12345',
            'user' => '67890',
            '--database' => [4, 5, 6],
        ]);
    }

    /** @test */
    public function it_shows_information_about_a_mysql_user()
    {
        $this->forge->shouldReceive()
            ->mysqlUser('12345', '67890')
            ->andReturn(
                new MysqlUser([
                    'id' => '::id::',
                    'serverId' => '12345',
                    'name' => '::name::',
                    'status' => '::status::',
                    'createdAt' => '::created-at::',
                ])
            );

        $tester = $this->command(Show::class);

        $tester->execute([
            'server' => '12345',
            'user' => '67890',
        ]);

        $output = $tester->getDisplay();

        $this->assertStringContainsString('::name::', $output);
        $this->assertStringContainsString('::status::', $output);
        $this->assertStringContainsString('::created-at::', $output);
    }
}
