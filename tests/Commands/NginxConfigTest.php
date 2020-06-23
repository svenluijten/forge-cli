<?php

namespace Sven\ForgeCLI\Tests\Commands;

use Sven\ForgeCLI\Commands\NginxConfig\Set;
use Sven\ForgeCLI\Tests\TestCase;

class NginxConfigTest extends TestCase
{
    /** @test */
    public function it_fails_if_file_is_missing()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The file provided "does-not-exist.test" was not found.');

        $tester = $this->command(Set::class);

        $tester->execute([
            'server' => '12345',
            'site' => '67890',
            '--file' => 'does-not-exist.test',
        ]);
    }
}
