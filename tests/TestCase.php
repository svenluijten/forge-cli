<?php

namespace Sven\ForgeCLI\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Themsaid\Forge\Forge;

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
     * @param string $abstract
     *
     * @return \Symfony\Component\Console\Tester\CommandTester
     */
    public function command($abstract)
    {
        $command = new $abstract($this->forge);

        (new Application('Forge CLI Testing'))->add($command);

        return new CommandTester($command);
    }
}
