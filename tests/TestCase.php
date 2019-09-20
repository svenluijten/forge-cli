<?php

namespace Sven\ForgeCLI\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Themsaid\Forge\Forge;
use Mockery as m;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var \Mockery\MockInterface&\Themsaid\Forge\Forge
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
        $configFile = __DIR__.'/fixtures/forge.json';

        if (file_exists($configFile)) {
            unlink($configFile);
        }
    }

    public function command(string $abstract): CommandTester
    {
        $command = new $abstract($this->forge);

        (new Application('Forge CLI Testing'))->add($command);

        return new CommandTester($command);
    }
}
