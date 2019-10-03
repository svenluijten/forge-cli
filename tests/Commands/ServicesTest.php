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
        $this->forge->shouldReceive()
            ->installBlackfire('12345', [
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
        $this->forge->shouldReceive()
            ->removeBlackfire('12345');

        $tester = $this->command(Uninstall::class)->setInputs(['yes']);

        $tester->execute([
            'server' => '12345',
            'service' => 'blackfire',
        ]);
    }

    /** @test */
    public function it_does_not_uninstall_blackfire_from_a_server_if_no_is_the_answer()
    {
        $this->forge->shouldNotReceive()
            ->removeBlackfire();

        $tester = $this->command(Uninstall::class)->setInputs(['no']);

        $tester->execute([
            'server' => '12345',
            'service' => 'blackfire',
        ]);

        $this->assertStringContainsString('Command Cancelled!', $tester->getDisplay());
    }

    /** @test */
    public function it_installs_papertrail_on_a_server()
    {
        $this->forge->shouldReceive()
            ->installPapertrail('12345', [
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
        $this->forge->shouldReceive()
            ->removePapertrail('12345');

        $tester = $this->command(Uninstall::class)->setInputs(['yes']);

        $tester->execute([
            'server' => '12345',
            'service' => 'papertrail',
        ]);
    }

    /** @test */
    public function it_does_not_uninstall_papertrail_from_a_server_if_no_is_the_answer()
    {
        $this->forge->shouldNotReceive()
            ->removePapertrail();

        $tester = $this->command(Uninstall::class)->setInputs(['no']);

        $tester->execute([
            'server' => '12345',
            'service' => 'papertrail',
        ]);

        $this->assertStringContainsString('Command Cancelled!', $tester->getDisplay());
    }

    /** @test */
    public function it_reboots_mysql()
    {
        $this->forge->shouldReceive()
            ->rebootMysql('12345');

        $tester = $this->command(Reboot::class)->setInputs(['yes']);

        $tester->execute([
            'server' => '12345',
            'service' => 'mysql',
        ]);
    }

    /** @test */
    public function it_does_not_reboot_mysql_if_no_is_the_answer()
    {
        $this->forge->shouldNotReceive()
            ->rebootMysql();

        $tester = $this->command(Reboot::class)->setInputs(['no']);

        $tester->execute([
            'server' => '12345',
            'service' => 'mysql',
        ]);

        $this->assertStringContainsString('Command Cancelled!', $tester->getDisplay());
    }

    /** @test */
    public function it_stops_mysql()
    {
        $this->forge->shouldReceive()
            ->stopMysql('12345');

        $tester = $this->command(Stop::class)->setInputs(['yes']);

        $tester->execute([
            'server' => '12345',
            'service' => 'mysql',
        ]);
    }

    /** @test */
    public function it_does_not_stop_mysql_if_no_is_the_answer()
    {
        $this->forge->shouldNotReceive()
            ->stopMysql();

        $tester = $this->command(Stop::class)->setInputs(['no']);

        $tester->execute([
            'server' => '12345',
            'service' => 'mysql',
        ]);

        $this->assertStringContainsString('Command Cancelled!', $tester->getDisplay());
    }

    /** @test */
    public function it_reboots_postgres()
    {
        $this->forge->shouldReceive()
            ->rebootPostgres('12345');

        $tester = $this->command(Reboot::class)->setInputs(['yes']);

        $tester->execute([
            'server' => '12345',
            'service' => 'postgres',
        ]);
    }

    /** @test */
    public function it_does_not_reboot_postgres_if_no_is_the_answer()
    {
        $this->forge->shouldNotReceive()
            ->rebootPostgres();

        $tester = $this->command(Reboot::class)->setInputs(['no']);

        $tester->execute([
            'server' => '12345',
            'service' => 'postgres',
        ]);

        $this->assertStringContainsString('Command Cancelled!', $tester->getDisplay());
    }

    /** @test */
    public function it_stops_postgres()
    {
        $this->forge->shouldReceive()
            ->stopPostgres('12345');

        $tester = $this->command(Stop::class)->setInputs(['yes']);

        $tester->execute([
            'server' => '12345',
            'service' => 'postgres',
        ]);
    }

    /** @test */
    public function it_does_not_stop_postgres_if_no_is_the_answer()
    {
        $this->forge->shouldNotReceive()
            ->stopPostgres();

        $tester = $this->command(Stop::class)->setInputs(['no']);

        $tester->execute([
            'server' => '12345',
            'service' => 'postgres',
        ]);

        $this->assertStringContainsString('Command Cancelled!', $tester->getDisplay());
    }

    /** @test */
    public function it_reboots_nginx()
    {
        $this->forge->shouldReceive()
            ->rebootNginx('12345');

        $tester = $this->command(Reboot::class)->setInputs(['yes']);

        $tester->execute([
            'server' => '12345',
            'service' => 'nginx',
        ]);
    }

    /** @test */
    public function it_does_not_reboot_nginx_if_no_is_the_answer()
    {
        $this->forge->shouldNotReceive()
            ->rebootNginx();

        $tester = $this->command(Reboot::class)->setInputs(['no']);

        $tester->execute([
            'server' => '12345',
            'service' => 'nginx',
        ]);

        $this->assertStringContainsString('Command Cancelled!', $tester->getDisplay());
    }

    /** @test */
    public function it_stops_nginx()
    {
        $this->forge->shouldReceive()
            ->stopNginx('12345');

        $tester = $this->command(Stop::class)->setInputs(['yes']);

        $tester->execute([
            'server' => '12345',
            'service' => 'nginx',
        ]);
    }

    /** @test */
    public function it_does_not_stop_nginx_if_no_is_the_answer()
    {
        $this->forge->shouldNotReceive()
            ->stopNginx();

        $tester = $this->command(Stop::class)->setInputs(['no']);

        $tester->execute([
            'server' => '12345',
            'service' => 'nginx',
        ]);

        $this->assertStringContainsString('Command Cancelled!', $tester->getDisplay());
    }
}
