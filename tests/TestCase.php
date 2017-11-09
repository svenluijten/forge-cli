<?php

namespace Sven\ForgeCLI\Tests;

use Themsaid\Forge\Forge;
use Symfony\Component\Console\Application;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Symfony\Component\Console\Tester\CommandTester;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $forge;

    /**
     * Set up the testing suite.
     */
    public function setUp()
    {
        $this->forge = $this->createMock(Forge::class);
    }

    /**
     * @param string   $abstract
     * @param callable $callback
     *
     * @return \Symfony\Component\Console\Tester\CommandTester
     */
    public function command($abstract, $callback = null)
    {
        $app = new Application('Forge CLI Testing');

        $command = new $abstract($this->forge);

        $app->add($command);

        $tester = new CommandTester($command);

        if (is_callable($callback)) {
            $callback($tester);
        }

        return $tester;
    }
}
