<?php

namespace Sven\ForgeCLI\Tests\Commands;

use Sven\ForgeCLI\Commands\Projects\DeleteGit;
use Sven\ForgeCLI\Commands\Projects\DeleteWordpress;
use Sven\ForgeCLI\Tests\TestCase;

class ProjectsTest extends TestCase
{
    /** @test */
    public function it_deletes_a_git_repository_on_a_site()
    {
        $this->forge->shouldReceive()
            ->destroySiteGitRepository('12345', '6789');

        $this->command(DeleteGit::class)
            ->setInputs(['yes'])
            ->execute([
                'server' => '12345',
                'site' => '6789',
            ]);
    }

    /** @test */
    public function it_forces_deletition_of_a_git_repository_on_a_site()
    {
        $this->forge->shouldReceive()
            ->destroySiteGitRepository('12345', '6789');

        $this->command(DeleteGit::class)
            ->execute([
                'server' => '12345',
                'site' => '6789',
                '--force' => true,
            ]);
    }

    /** @test */
    public function it_does_not_delete_a_git_repository_on_a_site_if_no_is_answered()
    {
        $this->forge->shouldNotReceive()
            ->destroySiteGitRepository();

        $tester = $this->command(DeleteGit::class)->setInputs(['no']);

        $tester->execute([
            'server' => '12345',
            'site' => '6789',
        ]);

        $this->assertStringContainsString('Command Cancelled!', $tester->getDisplay());
    }

    /** @test */
    public function it_deletes_a_wordpress_project()
    {
        $this->forge->shouldReceive()
            ->removeWordPress('12345', '6789');

        $this->command(DeleteWordpress::class)
            ->setInputs(['yes'])
            ->execute([
                'server' => '12345',
                'site' => '6789',
            ]);
    }

    /** @test */
    public function it_forces_deletition_of_a_wordpress_project()
    {
        $this->forge->shouldReceive()
            ->removeWordPress('12345', '6789');

        $this->command(DeleteWordpress::class)
            ->execute([
                'server' => '12345',
                'site' => '6789',
                '--force' => true,
            ]);
    }

    /** @test */
    public function it_does_not_delete_a_wordpress_project_if_no_is_answered()
    {
        $this->forge->shouldNotReceive()
            ->removeWordPress();

        $tester = $this->command(DeleteWordpress::class)->setInputs(['no']);

        $tester->execute([
            'server' => '12345',
            'site' => '6789',
        ]);

        $this->assertStringContainsString('Command Cancelled!', $tester->getDisplay());
    }
}
