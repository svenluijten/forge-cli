<?php

namespace Sven\ForgeCLI\Tests;

use Sven\ForgeCLI\Util;

class UtilTest extends TestCase
{
    /** @test */
    public function it_gets_the_home_directory(): void
    {
        $this->assertEquals(__DIR__.'/fixtures', Util::getHomeDirectory());
    }

    /** @test */
    public function it_returns_the_right_config_file(): void
    {
        $this->assertEquals(__DIR__.'/fixtures/.forge.json', Util::getConfigFilePath());

        touch(__DIR__.'/fixtures/forge.json');

        $this->assertEquals(__DIR__.'/fixtures/forge.json', Util::getConfigFilePath());
    }
}
