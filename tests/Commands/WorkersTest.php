<?php

namespace Sven\ForgeCLI\Tests\Commands;

use DateTime;
use Sven\ForgeCLI\Commands\Workers\All;
use Sven\ForgeCLI\Commands\Workers\Delete;
use Sven\ForgeCLI\Commands\Workers\Make;
use Sven\ForgeCLI\Commands\Workers\Reboot;
use Sven\ForgeCLI\Commands\Workers\Show;
use Sven\ForgeCLI\Tests\TestCase;
use Themsaid\Forge\Resources\Worker;

class WorkersTest extends TestCase
{
    /** @test */
    public function it_lists_all_workers_for_a_site()
    {
        $this->forge->shouldReceive()
            ->workers('12345', '6789')
            ->andReturn([
                new Worker(['id' => '1', 'connection' => 'test-connection', 'status' => 'test-status', 'created_at' => '']),
            ]);

        $tester = $this->command(All::class);

        $tester->execute([
            'server' => '12345',
            'site' => '6789',
        ]);

        $output = $tester->getDisplay();

        $this->assertStringContainsString('1', $output);
        $this->assertStringContainsString('test-connection', $output);
        $this->assertStringContainsString('test-status', $output);
    }

    /** @test */
    public function it_deletes_a_worker()
    {
        $this->forge->shouldReceive()
            ->deleteWorker('12345', '6789','10');

        $this->command(Delete::class)
            ->setInputs(['yes'])
            ->execute([
                'server' => '12345',
                'site' => '6789',
                'worker' => '10',
            ]);
    }

    /** @test */
    public function it_forces_deletition_of_a_worker()
    {
        $this->forge->shouldReceive()
            ->deleteWorker('12345', '6789', '10');

        $this->command(Delete::class)
            ->execute([
                'server' => '12345',
                'site' => '6789',
                'worker' => '10',
                '--force' => true,
            ]);
    }

    /** @test */
    public function it_does_not_delete_a_worker_if_no_is_answered()
    {
        $this->forge->shouldNotReceive()
            ->deleteWorker();

        $tester = $this->command(Delete::class)->setInputs(['no']);

        $tester->execute([
            'server' => '12345',
            'site' => '6789',
            'worker' => '10',
        ]);

        $this->assertStringContainsString('Command Cancelled!', $tester->getDisplay());
    }

    /** @test */
    public function it_makes_a_worker()
    {
        $this->forge->shouldReceive()
            ->createWorker('12345', '6789', [
                'connection' => 'sqs',
                'timeout' => '90',
                'sleep' => '60',
                'tries' => '3',
                'processes' => '1',
                'daemon' => true,
            ], false);

        $this->command(Make::class)->execute([
            'server' => '12345',
            'site' => '6789',
            '--connection' => 'sqs',
            '--timeout' => '90',
            '--sleep' => '60',
            '--tries' => '3',
            '--processes' => '1',
            '--daemon' => true,
        ]);
    }

    /** @test */
    public function it_defaults__when_making_a_worker()
    {
        $this->forge->shouldReceive()
            ->createWorker('12345', '6789', [
                'connection' => 'sqs',
                'timeout' => '90',
                'sleep' => '60',
                'tries' => '3',
                'processes' => '1',
                'daemon' => false,
            ], false);

        $this->command(Make::class)->execute([
            'server' => '12345',
            'site' => '6789',
            '--connection' => 'sqs',
            '--tries' => '3',
        ]);
    }

    /** @test */
    public function it_reboots_a_worker()
    {
        $this->forge->shouldReceive()
            ->restartWorker('12345', '6789','10', false);

        $this->command(Reboot::class)
            ->setInputs(['yes'])
            ->execute([
                'server' => '12345',
                'site' => '6789',
                'worker' => '10',
            ]);
    }

    /** @test */
    public function it_does_not_reboot_a_worker_if_no_is_answered()
    {
        $this->forge->shouldNotReceive()
            ->restartWorker();

        $tester = $this->command(Reboot::class)->setInputs(['no']);

        $tester->execute([
            'server' => '12345',
            'site' => '6789',
            'worker' => '10',
        ]);

        $this->assertStringContainsString('Command Cancelled!', $tester->getDisplay());
    }

     /** @test */
     public function it_force_reboot_a_worker_if_option_is_set()
     {
        $this->forge->shouldReceive()
            ->restartWorker('12345', '6789','10', false);

        $tester = $this->command(Reboot::class);

        $tester->execute([
            'server' => '12345',
            'site' => '6789',
            'worker' => '10',
            '--force' => true,
        ]);

     }

    /** @test */
    public function it_shows_information_about_a_site()
    {
        $this->forge->shouldReceive()
            ->worker('12345', '6789', '10')
            ->andReturn(new Worker([
                'status' => 'test-status',
                'connection' => 'test-connection',
                'timeout' => 'test-timeout',
                'command' => 'test-command',
                'daemon' => true,
                'created_at' => '',
                ],
                $this->forge));

        $tester = $this->command(Show::class);
        
        $tester->execute([
            'server' => '12345',
            'site' => '6789',
            'worker' => '10',
            ]);
        
        $output = $tester->getDisplay();

        $this->assertStringContainsString('test-status', $output);
        $this->assertStringContainsString('test-connection', $output);
        $this->assertStringContainsString('test-timeout', $output);
        $this->assertStringContainsString('test-command', $output);
        $this->assertStringContainsString('Yes', $output);
    }
    
}
