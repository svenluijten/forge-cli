<?php

namespace Sven\ForgeCLI\Tests;

use Laravel\Forge\Forge;
use Mockery as m;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var \Mockery\MockInterface&\Laravel\Forge\Forge
     */
    protected $forge;

    public function setUp(): void
    {
        $this->forge = m::mock(Forge::class);

        /* @see \Sven\ForgeCLI\Commands\BaseCommand::getFileConfig */
        $_SERVER['USERPROFILE'] = __DIR__.'/fixtures';
        $_SERVER['HOME'] = __DIR__.'/fixtures';
    }

    public function tearDown(): void
    {
        $configFiles = [
            __DIR__.'/fixtures/forge.json',
            __DIR__.'/fixtures/.forge.json',
        ];

        foreach ($configFiles as $configFile) {
            if (file_exists($configFile)) {
                unlink($configFile);
            }
        }
    }

    public function command(string $abstract): CommandTester
    {
        $command = new $abstract($this->forge);

        (new Application('Forge CLI Testing'))->add($command);

        return new CommandTester($command);
    }
}
