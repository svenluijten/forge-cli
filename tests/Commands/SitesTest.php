<?php

namespace Sven\ForgeCLI\Tests\Commands;

use Sven\ForgeCLI\Commands\Sites\All;
use Sven\ForgeCLI\Commands\Sites\Delete;
use Sven\ForgeCLI\Commands\Sites\Deploy;
use Sven\ForgeCLI\Commands\Sites\Make;
use Sven\ForgeCLI\Commands\Sites\Show;
use Sven\ForgeCLI\Commands\Sites\Update;
use Sven\ForgeCLI\Tests\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Themsaid\Forge\Resources\Site;

class SitesTest extends TestCase
{
    /** @test */
    public function it_lists_all_sites()
    {
        $this->forge->shouldReceive('sites')
            ->with('12345')
            ->andReturn([
                new Site([]),
            ]);

        $this->command(All::class)->execute([
            'server' => 12345,
        ]);
    }

    /** @test */
    public function it_deletes_a_site()
    {
        $this->forge->shouldReceive('deleteSite')
            ->with('12345', '6789');

        $tester = $this->command(Delete::class, function (CommandTester $tester) {
            $tester->setInputs(['yes']);
        });

        $tester->execute([
            'server' => 12345,
            'site' => 6789,
        ]);
    }

    /** @test */
    public function it_deploys_a_site()
    {
        $this->forge->shouldReceive('deploySite')
            ->with('12345', '6789');

        $this->command(Deploy::class)->execute([
            'server' => 12345,
            'site' => 6789,
        ]);
    }

    /** @test */
    public function it_creates_a_site()
    {
        $this->forge->shouldReceive('createSite')
            ->with(12345, [
                'domain' => 'example.com',
                'project_type' => 'symfony_dev',
                'directory' => '/public',
            ], false);

        $this->command(Make::class)->execute([
            'server' => 12345,
            '--domain' => 'example.com',
            '--type' => 'symfony_dev',
            '--directory' => '/public',
        ]);
    }

    /** @test */
    public function it_defaults_to_php_site_when_not_supplying_the_option()
    {
        $this->forge->shouldReceive('createSite')
            ->with(12345, [
                'domain' => 'example.com',
                'project_type' => 'php',
                'directory' => '/public_html',
            ], false);

        $this->command(Make::class)->execute([
            'server' => 12345,
            '--domain' => 'example.com',
            '--directory' => '/public_html',
        ]);
    }

    /** @test */
    public function it_defaults_to_public_directory_when_not_supplying_the_option()
    {
        $this->forge->shouldReceive('createSite')
            ->with(12345, [
                'domain' => 'example.com',
                'project_type' => 'Symfony',
                'directory' => '/public',
            ], false);

        $this->command(Make::class)->execute([
            'server' => 12345,
            '--domain' => 'example.com',
            '--type' => 'Symfony',
        ]);
    }

    /** @test */
    public function it_shows_information_about_a_site()
    {
        $this->forge->shouldReceive('site')
            ->with(12345, 6789)
            ->andReturn(new Site([], $this->forge));

        $this->command(Show::class)->execute([
            'server' => 12345,
            'site' => 6789,
        ]);
    }

    /** @test */
    public function it_updates_a_site()
    {
        $this->forge->shouldReceive('updateSite')
            ->with(12345, 6789, [
                'directory' => '/public_html',
            ]);

        $this->command(Update::class)->execute([
            'server' => 12345,
            'site' => 6789,
            '--directory' => '/public_html',
        ]);
    }
}
