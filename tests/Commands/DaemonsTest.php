<?php

namespace Sven\ForgeCLI\Tests\Commands;

use Sven\ForgeCLI\Commands\Daemons\All;
use Sven\ForgeCLI\Commands\Daemons\Delete;
use Sven\ForgeCLI\Commands\Daemons\Make;
use Sven\ForgeCLI\Commands\Daemons\Reboot;
use Sven\ForgeCLI\Commands\Daemons\Show;
use Sven\ForgeCLI\Tests\TestCase;
use Themsaid\Forge\Resources\Daemon;

class DaemonsTest extends TestCase
{
    /** @test */
    public function it_lists_all_daemons_on_a_server()
    {
        $this->forge->shouldReceive()
            ->daemons('12345')
            ->once()
            ->andReturn([
                new Daemon(['id' => '67890', 'command' => 'echo \'hello world\' >> /dev/null']),
            ]);

        $tester = $this->command(All::class);

        $tester->execute([
            'server' => '12345',
        ]);

        $output = $tester->getDisplay();

        $this->assertStringContainsString('67890', $output);
        $this->assertStringContainsString('echo \'hello world\' >> /dev/null', $output);
    }

    /** @test */
    public function it_deletes_a_daemon()
    {
        $this->forge->shouldReceive()
            ->deleteDaemon('12345', '67890');

        $this->command(Delete::class)
            ->setInputs(['yes'])
            ->execute([
                'server' => '12345',
                'daemon' => '67890',
            ]);
    }

    /** @test */
    public function it_does_not_delete_the_daemon_if_no_is_answered()
    {
        $this->forge->shouldNotReceive()
            ->deleteDaemon();

        $this->command(Delete::class)
            ->setInputs(['no'])
            ->execute([
                'server' => '12345',
                'daemon' => '67890',
            ]);
    }

    /** @test */
    public function it_makes_a_daemon()
    {
        $this->forge->shouldReceive()
            ->createDaemon('12345', [
                'command' => 'echo \'hello world\' >> /dev/null',
                'user' => 'forge',
            ], false);

        $this->command(Make::class)->execute([
            'server' => '12345',
            '--command' => 'echo \'hello world\' >> /dev/null',
            '--user' => 'forge',
        ]);
    }

    /** @test */
    public function it_reboots_a_running_daemon()
    {
        $this->forge->shouldReceive()
            ->restartDaemon('12345', '67890', false);

        $this->command(Reboot::class)
            ->setInputs(['yes'])
            ->execute([
                'server' => '12345',
                'daemon' => '67890',
            ]);
    }

    /** @test */
    public function it_does_not_reboot_the_daemon_if_no_is_answered()
    {
        $this->forge->shouldReceive()
            ->restartDaemon('12345', '67890');

        $this->command(Reboot::class)
            ->setInputs(['no'])
            ->execute([
                'server' => '12345',
                'daemon' => '67890',
            ]);
    }

    /** @test */
    public function it_shows_information_about_a_daemon()
    {
        $this->forge->shouldReceive()
            ->daemon('12345', '67890')
            ->andReturn(
                new Daemon(['id' => '67890', 'command' => 'echo \'hello world\' >> /dev/null', 'status' => 'active'])
            );

        $tester = $this->command(Show::class);

        $tester->execute([
            'server' => '12345',
            'daemon' => '67890',
        ]);

        $this->assertStringContainsString('\'hello world\'', $tester->getDisplay());
        $this->assertStringContainsString('active', $tester->getDisplay());
    }
}
