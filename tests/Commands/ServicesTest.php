<?php

namespace Sven\ForgeCLI\Tests\Commands;

use Sven\ForgeCLI\Commands\Services\Install;
use Sven\ForgeCLI\Commands\Services\Reboot;
use Sven\ForgeCLI\Commands\Services\Stop;
use Sven\ForgeCLI\Commands\Services\Uninstall;
use Sven\ForgeCLI\Tests\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

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

        $tester = $this->command(Uninstall::class, function (CommandTester $tester) {
            $tester->setInputs(['yes']);
        });

        $tester->execute([
            'server' => '12345',
            'service' => 'blackfire',
        ]);
    }

    /** @test */
    public function it_does_not_uninstall_blackfire_from_a_server_if_no_is_the_answer()
    {
        $this->forge->expects($this->exactly(0))
            ->method('removeBlackfire')
            ->with('12345');

        $tester = $this->command(Uninstall::class, function (CommandTester $tester) {
            $tester->setInputs(['no']);
        });

        $tester->execute([
            'server' => '12345',
            'service' => 'blackfire',
        ]);

        $this->assertContains('aborting', $tester->getDisplay());
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

        $tester = $this->command(Uninstall::class, function (CommandTester $tester) {
            $tester->setInputs(['yes']);
        });

        $tester->execute([
            'server' => '12345',
            'service' => 'papertrail',
        ]);
    }

    /** @test */
    public function it_does_not_uninstall_papertrail_from_a_server_if_no_is_the_answer()
    {
        $this->forge->expects($this->exactly(0))
            ->method('removePapertrail')
            ->with('12345');

        $tester = $this->command(Uninstall::class, function (CommandTester $tester) {
            $tester->setInputs(['no']);
        });

        $tester->execute([
            'server' => '12345',
            'service' => 'papertrail',
        ]);

        $this->assertContains('aborting', $tester->getDisplay());
    }

    /** @test */
    public function it_reboots_mysql()
    {
        $this->forge->expects($this->once())
            ->method('rebootMysql')
            ->with('12345');

        $tester = $this->command(Reboot::class, function (CommandTester $tester) {
            $tester->setInputs(['yes']);
        });

        $tester->execute([
            'server' => '12345',
            'service' => 'mysql',
        ]);
    }

    /** @test */
    public function it_does_not_reboot_mysql_if_no_is_the_answer()
    {
        $this->forge->expects($this->exactly(0))
            ->method('rebootMysql')
            ->with('12345');

        $tester = $this->command(Reboot::class, function (CommandTester $tester) {
            $tester->setInputs(['no']);
        });

        $tester->execute([
            'server' => '12345',
            'service' => 'mysql',
        ]);

        $this->assertContains('aborting', $tester->getDisplay());
    }

    /** @test */
    public function it_stops_mysql()
    {
        $this->forge->expects($this->once())
            ->method('stopMysql')
            ->with('12345');

        $tester = $this->command(Stop::class, function (CommandTester $tester) {
            $tester->setInputs(['yes']);
        });

        $tester->execute([
            'server' => '12345',
            'service' => 'mysql',
        ]);
    }

    /** @test */
    public function it_does_not_stop_mysql_if_no_is_the_answer()
    {
        $this->forge->expects($this->exactly(0))
            ->method('stopMysql')
            ->with('12345');

        $tester = $this->command(Stop::class, function (CommandTester $tester) {
            $tester->setInputs(['no']);
        });

        $tester->execute([
            'server' => '12345',
            'service' => 'mysql',
        ]);

        $this->assertContains('aborting', $tester->getDisplay());
    }

    /** @test */
    public function it_reboots_postgres()
    {
        $this->forge->expects($this->once())
            ->method('rebootPostgres')
            ->with('12345');

        $tester = $this->command(Reboot::class, function (CommandTester $tester) {
            $tester->setInputs(['yes']);
        });

        $tester->execute([
            'server' => '12345',
            'service' => 'postgres',
        ]);
    }

    /** @test */
    public function it_does_not_reboot_postgres_if_no_is_the_answer()
    {
        $this->forge->expects($this->exactly(0))
            ->method('rebootPostgres')
            ->with('12345');

        $tester = $this->command(Reboot::class, function (CommandTester $tester) {
            $tester->setInputs(['no']);
        });

        $tester->execute([
            'server' => '12345',
            'service' => 'postgres',
        ]);

        $this->assertContains('aborting', $tester->getDisplay());
    }

    /** @test */
    public function it_stops_postgres()
    {
        $this->forge->expects($this->once())
            ->method('stopPostgres')
            ->with('12345');

        $tester = $this->command(Stop::class, function (CommandTester $tester) {
            $tester->setInputs(['yes']);
        });

        $tester->execute([
            'server' => '12345',
            'service' => 'postgres',
        ]);
    }

    /** @test */
    public function it_does_not_stop_postgres_if_no_is_the_answer()
    {
        $this->forge->expects($this->exactly(0))
            ->method('stopPostgres')
            ->with('12345');

        $tester = $this->command(Stop::class, function (CommandTester $tester) {
            $tester->setInputs(['no']);
        });

        $tester->execute([
            'server' => '12345',
            'service' => 'postgres',
        ]);

        $this->assertContains('aborting', $tester->getDisplay());
    }

    /** @test */
    public function it_reboots_nginx()
    {
        $this->forge->expects($this->once())
            ->method('rebootNginx')
            ->with('12345');

        $tester = $this->command(Reboot::class, function (CommandTester $tester) {
            $tester->setInputs(['yes']);
        });

        $tester->execute([
            'server' => '12345',
            'service' => 'nginx',
        ]);
    }

    /** @test */
    public function it_does_not_reboot_nginx_if_no_is_the_answer()
    {
        $this->forge->expects($this->exactly(0))
            ->method('rebootNginx')
            ->with('12345');

        $tester = $this->command(Reboot::class, function (CommandTester $tester) {
            $tester->setInputs(['no']);
        });

        $tester->execute([
            'server' => '12345',
            'service' => 'nginx',
        ]);

        $this->assertContains('aborting', $tester->getDisplay());
    }

    /** @test */
    public function it_stops_nginx()
    {
        $this->forge->expects($this->once())
            ->method('stopNginx')
            ->with('12345');

        $tester = $this->command(Stop::class, function (CommandTester $tester) {
            $tester->setInputs(['yes']);
        });

        $tester->execute([
            'server' => '12345',
            'service' => 'nginx',
        ]);
    }

    /** @test */
    public function it_does_not_stop_nginx_if_no_is_the_answer()
    {
        $this->forge->expects($this->exactly(0))
            ->method('stopNginx')
            ->with('12345');

        $tester = $this->command(Stop::class, function (CommandTester $tester) {
            $tester->setInputs(['no']);
        });

        $tester->execute([
            'server' => '12345',
            'service' => 'nginx',
        ]);

        $this->assertContains('aborting', $tester->getDisplay());
    }
}
