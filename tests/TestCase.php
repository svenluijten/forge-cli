<?php

namespace Sven\ForgeCLI\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Themsaid\Forge\Forge;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var \Themsaid\Forge\Forge
     */
    protected $forge;

    /**
     * Set up the testing suite.
     */
    public function setUp()
    {
        $this->forge = m::mock(Forge::class);
    }

    /**
     * Tear down the testing suite.
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * @param string   $abstract
     * @param callable $callback
     *
     * @return \Symfony\Component\Console\Tester\CommandTester
     */
    public function command($abstract, callable $callback = null)
    {
        $app = new Application('Forge CLI Testing');

        $command = new $abstract($forge ?? $this->forge);

        $app->add($command);

        $tester = new CommandTester($command);

        if (is_callable($callback)) {
            $callback($tester);
        }

        return $tester;
    }
}
