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
        $this->forge->expects($this->once())
            ->method('daemons')
            ->with('12345')
            ->willReturn([
                new Daemon(['id' => '67890', 'command' => 'echo \'hello world\' >> /dev/null']),
            ]);

        $tester = $this->command(All::class);

        $tester->execute([
            'server' => '12345',
        ]);

        $output = $tester->getDisplay();

        $this->assertContains('67890', $output);
        $this->assertContains('echo \'hello world\' >> /dev/null', $output);
    }

    /** @test */
    public function it_deletes_a_daemon()
    {
        $this->forge->expects($this->once())
            ->method('deleteDaemon')
            ->with('12345', '67890');

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
        $this->forge->expects($this->exactly(0))
            ->method('deleteDaemon')
            ->with('12345', '67890');

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
        $this->forge->expects($this->once())
            ->method('createDaemon')
            ->with('12345', [
                'command' => 'echo \'hello world\' >> /dev/null',
                'user' => 'forge',
            ]);

        $this->command(Make::class)->execute([
            'server' => '12345',
            '--command' => 'echo \'hello world\' >> /dev/null',
            '--user' => 'forge',
        ]);
    }

    /** @test */
    public function it_reboots_a_running_daemon()
    {
        $this->forge->expects($this->once())
            ->method('restartDaemon')
            ->with('12345', '67890');

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
        $this->forge->expects($this->exactly(0))
            ->method('restartDaemon')
            ->with('12345', '67890');

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
        $this->forge->expects($this->once())
            ->method('daemon')
            ->with('12345', '67890')
            ->willReturn(
                new Daemon(['id' => '67890', 'command' => 'echo \'hello world\' >> /dev/null'])
            );

        $this->command(Show::class)
            ->execute([
                'server' => '12345',
                'daemon' => '67890',
            ]);
    }
}
