<?php

namespace Sven\ForgeCLI\Tests;

use Laravel\Forge\Forge;
use Mockery as m;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Sven\FileConfig\Drivers\Json;
use Sven\FileConfig\File;
use Sven\FileConfig\Store;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var \Mockery\MockInterface&\Laravel\Forge\Forge
     */
    protected $forge;

    /**
     * @var \Sven\FileConfig\Store
     */
    protected $config;

    public function setUp(): void
    {
        $this->forge = m::mock(Forge::class);

        /* @see \Sven\ForgeCLI\Util::getHomeDirectory() */
        $_SERVER['USERPROFILE'] = __DIR__.'/fixtures';
        $_SERVER['HOME'] = __DIR__.'/fixtures';

        $file = __DIR__.'/fixtures/.forge.json';

        file_put_contents($file, '{}');
        $this->config = new Store(new File($file), new Json());
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
        $command = new $abstract($this->config, $this->forge);

        (new Application('Forge CLI Testing'))->add($command);

        return new CommandTester($command);
    }
}
