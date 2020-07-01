<?php

namespace Sven\ForgeCLI\Tests\Commands;

use Themsaid\Forge\Resources\Site;
use Sven\ForgeCLI\Commands\Servers\Delete;
use Sven\ForgeCLI\Commands\Servers\ListAll;
use Sven\ForgeCLI\Commands\Servers\Make;
use Sven\ForgeCLI\Commands\Servers\Reboot;
use Sven\ForgeCLI\Commands\Servers\Show;
use Sven\ForgeCLI\Commands\Servers\Update;
use Sven\ForgeCLI\Tests\TestCase;
use Themsaid\Forge\Resources\Server;
use Sven\ForgeCLI\Commands\Servers\SshConfig;

class ServersTest extends TestCase
{
    /** @test */
    public function it_lists_all_servers()
    {
        $this->forge->shouldReceive()
            ->servers()
            ->andReturn([
                new Server(['id' => '1234', 'ip_address' => '127.0.0.1']),
            ]);

        $tester = $this->command(ListAll::class);

        $tester->execute([]);

        $output = $tester->getDisplay();

        $this->assertStringContainsString('1234', $output);
        $this->assertStringContainsString('127.0.0.1', $output);
    }

    /** @test */
    public function it_deletes_a_server()
    {
        $this->forge->shouldReceive()
            ->deleteServer('1234');

        $this->command(Delete::class)
            ->setInputs(['yes'])
            ->execute([
                'server' => '1234',
            ]);
    }

    /** @test */
    public function it_creates_a_server()
    {
        $this->forge->shouldReceive()
            ->createServer([
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
        $this->forge->shouldReceive()
            ->rebootServer('12345');

        $this->command(Reboot::class)
            ->setInputs(['yes'])
            ->execute([
                'server' => '12345',
            ]);
    }

    /** @test */
    public function it_does_not_reboot_the_server_if_no_is_answered()
    {
        $this->forge->shouldNotReceive()
            ->rebootServer();

        $tester = $this->command(Reboot::class)->setInputs(['no']);

        $tester->execute([
            'server' => '12345',
        ]);

        $this->assertStringContainsString('aborting', $tester->getDisplay());
    }

    /** @test */
    public function it_shows_information_about_a_server()
    {
        $this->forge->shouldReceive()
            ->server('12345')
            ->andReturn(
                new Server(['id' => '12345', 'name' => 'Name of the server'])
            );

        $tester = $this->command(Show::class);

        $tester->execute([
            'server' => '12345',
        ]);

        $output = preg_replace('/\s{2,}/', ' ', $tester->getDisplay());

        $this->assertStringContainsString('Name: Name of the server', $output);
    }

    /** @test */
    public function it_updates_a_server()
    {
        $this->forge->shouldReceive()
            ->updateServer('12345', [
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

    /** @test */
    public function it_generates_an_ssh_config()
    {
        $this->forge->shouldReceive()
            ->servers()
            ->andReturn([
                new Server(['id' => '1234', 'name' => 'test', 'ip_address' => '127.0.0.1', 'ssh_port' => 22]),
            ]);

        $tester = $this->command(SshConfig::class);

        $tester->execute([]);

        $output = $tester->getDisplay();

        $this->assertStringContainsString('Host test', $output);
        $this->assertStringContainsString('    User forge', $output);
        $this->assertStringContainsString('    Port 22', $output);
        $this->assertStringContainsString('    Hostname 127.0.0.1', $output);
    }

    /** @test */
    public function it_generates_an_ssh_config_with_sites()
    {
        $this->forge->shouldReceive()
            ->servers()
            ->andReturn([
                new Server(['id' => '1234', 'name' => 'test', 'ip_address' => '127.0.0.1', 'ssh_port' => 22]),
            ]);

        $this->forge->shouldReceive()
            ->sites('1234')
            ->andReturn([
                new Site(['id' => '1234', 'name' => 'site-test', 'server_id' => '1234', 'username' => 'notforge']),
            ]);


        $tester = $this->command(SshConfig::class);

        $tester->execute(['--with-sites' => true]);

        $output = $tester->getDisplay();

        $this->assertStringContainsString('Host test', $output);
        $this->assertStringContainsString('    User forge', $output);
        $this->assertStringContainsString('    Port 22', $output);
        $this->assertStringContainsString('    Hostname 127.0.0.1', $output);

        $this->assertStringContainsString('Host test:site-test', $output);
        $this->assertStringContainsString('    User notforge', $output);
        $this->assertStringContainsString('    RequestTTY yes', $output);
        $this->assertStringContainsString('    RemoteCommand cd site-test; exec $SHELL;', $output);
    }
}
