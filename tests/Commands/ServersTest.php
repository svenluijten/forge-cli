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

class ServersTest extends TestCase
{
    /** @test */
    public function it_lists_all_servers()
    {
        $this->forge->expects($this->once())
            ->method('servers')
            ->willReturn([
                new Server(['id' => '1234', 'ip_address' => '127.0.0.1']),
            ]);

        $tester = $this->command(All::class);

        $tester->execute([]);

        $output = $tester->getDisplay();

        $this->assertContains('1234', $output);
        $this->assertContains('127.0.0.1', $output);
    }

    /** @test */
    public function it_deletes_a_server()
    {
        $this->forge->expects($this->once())
            ->method('deleteServer')
            ->with('1234');

        $this->command(Delete::class)
            ->setInputs(['yes'])
            ->execute([
                'server' => '1234',
            ]);
    }

    /** @test */
    public function it_creates_a_server()
    {
        $this->forge->expects($this->once())
            ->method('createServer')
            ->with([
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
        $this->forge->expects($this->once())
            ->method('rebootServer')
            ->with('12345');

        $this->command(Reboot::class)
            ->setInputs(['yes'])
            ->execute([
                'server' => '12345',
            ]);
    }

    /** @test */
    public function it_does_not_reboot_the_server_if_no_is_answered()
    {
        $this->forge->expects($this->exactly(0))
            ->method('rebootServer')
            ->with('12345');

        $tester = $this->command(Reboot::class)->setInputs(['no']);

        $tester->execute([
            'server' => '12345',
        ]);

        $this->assertContains('aborting', $tester->getDisplay());
    }

    /** @test */
    public function it_shows_information_about_a_server()
    {
        $this->forge->expects($this->once())
            ->method('server')
            ->with('12345')
            ->willReturn(
                new Server(['id' => '12345', 'name' => 'Name of the server'])
            );

        $tester = $this->command(Show::class);

        $tester->execute([
            'server' => '12345',
        ]);

        $output = preg_replace('/\s{2,}/', ' ', $tester->getDisplay());

        $this->assertContains('Name: Name of the server', $output);
    }

    /** @test */
    public function it_updates_a_server()
    {
        $this->forge->expects($this->once())
            ->method('updateServer')
            ->with('12345', [
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
