<?php

namespace Sven\ForgeCLI\Tests\Commands;

use Sven\ForgeCLI\Tests\TestCase;
use Themsaid\Forge\Resources\Server;
use Sven\ForgeCLI\Commands\Servers\All;
use Sven\ForgeCLI\Commands\Servers\Make;
use Sven\ForgeCLI\Commands\Servers\Show;
use Sven\ForgeCLI\Commands\Servers\Delete;
use Sven\ForgeCLI\Commands\Servers\Reboot;
use Sven\ForgeCLI\Commands\Servers\Update;
use Symfony\Component\Console\Tester\CommandTester;

class ServersTest extends TestCase
{
    /** @test */
    public function it_lists_all_servers()
    {
        $this->forge->shouldReceive('servers')->andReturn([
            new Server([]),
        ]);

        $this->command(All::class)->execute([]);
    }

    /** @test */
    public function it_deletes_a_server()
    {
        $this->forge->shouldReceive('deleteServer')->with('1234');

        $tester = $this->command(Delete::class, function (CommandTester $tester) {
            $tester->setInputs(['yes']);
        });

        $tester->execute([
            'server' => '1234',
        ]);
    }

    /** @test */
    public function it_creates_a_server()
    {
        $this->forge->shouldReceive('createServer')->with([
            'provider' => 'ocean2',
            'credential_id' => '1234',
            'region' => 'AMS2',
            'ip_address' => '127.0.0.1',
            'private_ip_address' => '192.168.1.1',
            'php_version' => 'php71',
            'database' => 'testing',
            'maria' => false,
            'load_balancer' => false,
            'network' => [],
        ]);

        $this->command(Make::class)->execute([
            '--provider' => 'ocean2',
            '--credentials' => '1234',
            '--region' => 'AMS2',
            '--ip' => '127.0.0.1',
            '--private-ip' => '192.168.1.1',
            '--php' => 'php71',
            '--database' => 'testing',
        ]);
    }

    /** @test */
    public function it_reboots_the_server()
    {
        $this->forge->shouldReceive('rebootServer')->with('12345');

        $tester = $this->command(Reboot::class, function (CommandTester $tester) {
            $tester->setInputs(['yes']);
        });

        $tester->execute([
            'server' => '12345',
        ]);
    }

    /** @test */
    public function it_shows_information_about_a_server()
    {
        $this->forge->shouldReceive('server')->with('12345')->andReturn(
            new Server([])
        );

        $this->command(Show::class)->execute([
            'server' => '12345',
        ]);

        // @todo verify that all required info is ouput to the screen?
    }

    /** @test */
    public function it_updates_a_server()
    {
        $this->forge->shouldReceive('updateServer')->with('12345', [
            'name' => 'New Name',
            'size' => '512MB',
            'ip_address' => '127.0.0.1',
            'private_ip_address' => '192.168.1.1',
            'max_upload_size' => '2GB',
            'network' => [],
        ]);

        $this->command(Update::class)->execute([
            'server' => '12345',
            '--name' => 'New Name',
            '--size' => '512MB',
            '--ip' => '127.0.0.1',
            '--private-ip' => '192.168.1.1',
            '--max-upload-size' => '2GB',
        ]);
    }
}
