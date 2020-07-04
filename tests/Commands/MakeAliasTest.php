<?php

namespace Sven\ForgeCLI\Tests\Commands;

use Sven\ForgeCLI\Commands\MakeAlias;
use Sven\ForgeCLI\Tests\TestCase;

class MakeAliasTest extends TestCase
{
    /** @test */
    public function it_can_alias_a_server(): void
    {
        $this->command(MakeAlias::class)
            ->setInputs([null])
            ->execute([
                'alias' => 'an-alias',
                'server' => '12345',
            ]);

        $config = $this->getConfig();

        $this->assertArrayHasKey('aliases', $config);
        $this->assertArrayHasKey('an-alias', $config['aliases']);
        $this->assertArrayHasKey('server', $config['aliases']['an-alias']);
        $this->assertEquals('12345', $config['aliases']['an-alias']['server']);
    }

    /** @test */
    public function it_asks_the_user_for_a_server_to_alias_when_not_provided(): void
    {
        $this->command(MakeAlias::class)
            ->setInputs(['12345', null])
            ->execute(['alias' => 'an-alias']);

        $config = $this->getConfig();

        $this->assertArrayHasKey('aliases', $config);
        $this->assertArrayHasKey('an-alias', $config['aliases']);
        $this->assertArrayHasKey('server', $config['aliases']['an-alias']);
        $this->assertEquals('12345', $config['aliases']['an-alias']['server']);
    }

    /** @test */
    public function it_can_alias_a_server_and_a_site(): void
    {
        $this->command(MakeAlias::class)
            ->execute([
                'alias' => 'an-alias',
                'server' => '12345',
                'site' => '67890',
            ]);

        $config = $this->getConfig();

        $this->assertArrayHasKey('aliases', $config);
        $this->assertArrayHasKey('an-alias', $config['aliases']);
        $this->assertArrayHasKey('server', $config['aliases']['an-alias']);
        $this->assertArrayHasKey('site', $config['aliases']['an-alias']);

        $this->assertEquals('12345', $config['aliases']['an-alias']['server']);
        $this->assertEquals('67890', $config['aliases']['an-alias']['site']);
    }

    /** @test */
    public function it_asks_for_a_server_and_site_to_alias_if_none_are_given(): void
    {
        $this->command(MakeAlias::class)
            ->setInputs(['12345', '67890'])
            ->execute(['alias' => 'an-alias']);

        $config = $this->getConfig();

        $this->assertArrayHasKey('aliases', $config);
        $this->assertArrayHasKey('an-alias', $config['aliases']);
        $this->assertArrayHasKey('server', $config['aliases']['an-alias']);
        $this->assertArrayHasKey('site', $config['aliases']['an-alias']);

        $this->assertEquals('12345', $config['aliases']['an-alias']['server']);
        $this->assertEquals('67890', $config['aliases']['an-alias']['site']);
    }

    protected function getConfig(): array
    {
        return json_decode(file_get_contents(__DIR__.'/../fixtures/.forge.json'), true);
    }
}
