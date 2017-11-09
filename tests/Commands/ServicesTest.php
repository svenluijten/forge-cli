<?php

namespace Sven\ForgeCLI\Tests\Commands;

use Sven\ForgeCLI\Commands\Services\Install;
use Sven\ForgeCLI\Commands\Services\Reboot;
use Sven\ForgeCLI\Commands\Services\Stop;
use Sven\ForgeCLI\Commands\Services\Uninstall;
use Sven\ForgeCLI\Tests\TestCase;

class ServicesTest extends TestCase
{
    /** @test */
    public function it_installs_blackfire_on_a_server()
    {
        $this->forge->expects($this->once())
            ->method('installBlackfire')
            ->with('12345', [
                'server_id' => 'blackfire-server-id',
                'server_token' => 'blackfire-server-token',
            ]);

        $this->command(Install::class)->execute([
            'server' => '12345',
            'service' => 'blackfire',
            '--server-id' => 'blackfire-server-id',
            '--server-token' => 'blackfire-server-token',
        ]);
    }

    /** @test */
    public function it_uninstalls_blackfire_from_a_server()
    {
        $this->forge->expects($this->once())
            ->method('removeBlackfire')
            ->with('12345');

        $this->command(Uninstall::class)->execute([
            'server' => '12345',
            'service' => 'blackfire',
        ]);
    }

    /** @test */
    public function it_installs_papertrail_on_a_server()
    {
        $this->forge->expects($this->once())
            ->method('installPapertrail')
            ->with('12345', [
                'host' => 'papertrail-host',
            ]);

        $this->command(Install::class)->execute([
            'server' => '12345',
            'service' => 'papertrail',
            '--host' => 'papertrail-host',
        ]);
    }

    /** @test */
    public function it_uninstalls_papertrail_from_a_server()
    {
        $this->forge->expects($this->once())
            ->method('removePapertrail')
            ->with('12345');

        $this->command(Uninstall::class)->execute([
            'server' => '12345',
            'service' => 'papertrail',
        ]);
    }

    /** @test */
    public function it_reboots_mysql()
    {
        $this->forge->expects($this->once())
            ->method('rebootMysql')
            ->with('12345');

        $this->command(Reboot::class)->execute([
            'server' => '12345',
            'service' => 'mysql',
        ]);
    }

    /** @test */
    public function it_stops_mysql()
    {
        $this->forge->expects($this->once())
            ->method('stopMysql')
            ->with('12345');

        $this->command(Stop::class)->execute([
            'server' => '12345',
            'service' => 'mysql',
        ]);
    }

    /** @test */
    public function it_reboots_postgres()
    {
        $this->forge->expects($this->once())
            ->method('rebootPostgres')
            ->with('12345');

        $this->command(Reboot::class)->execute([
            'server' => '12345',
            'service' => 'postgres',
        ]);
    }

    /** @test */
    public function it_stops_postgres()
    {
        $this->forge->expects($this->once())
            ->method('stopPostgres')
            ->with('12345');

        $this->command(Stop::class)->execute([
            'server' => '12345',
            'service' => 'postgres',
        ]);
    }

    /** @test */
    public function it_reboots_nginx()
    {
        $this->forge->expects($this->once())
            ->method('rebootNginx')
            ->with('12345');

        $this->command(Reboot::class)->execute([
            'server' => '12345',
            'service' => 'nginx',
        ]);
    }

    /** @test */
    public function it_stops_nginx()
    {
        $this->forge->expects($this->once())
            ->method('stopNginx')
            ->with('12345');

        $this->command(Stop::class)->execute([
            'server' => '12345',
            'service' => 'nginx',
        ]);
    }
}
