<?php

namespace Sven\ForgeCLI\Tests\Commands;

use Sven\ForgeCLI\Commands\Certificates\Activate;
use Sven\ForgeCLI\Commands\Certificates\Delete;
use Sven\ForgeCLI\Tests\TestCase;
use Themsaid\Forge\Resources\Certificate;

class CertificatesTest extends TestCase
{
    /** @test */
    public function it_can_activate_a_certificate()
    {
        $this->forge->shouldReceive()
            ->activateCertificate('12345', '67890', '13579', false)
            ->once()
            ->andReturn([
                new Certificate(['id' => '13579', 'serverId' => '12345', 'siteId' => '67890']),
            ]);

        $tester = $this->command(Activate::class);

        $tester->execute([
            'server' => '12345',
            'site' => '67890',
            'certificate' => '13579',
        ]);
    }

    public function it_deletes_a_certificate()
    {
        $this->forge->shouldReceive()
            ->deleteCertificate('12345', '6789', '13579');

        $this->command(Delete::class)
            ->setInputs(['yes'])
            ->execute([
                'server' => '12345',
                'site' => '6789',
                'certificate' => '13579',
            ]);
    }

    /** @test */
    public function it_forces_deletition_of_a_certificate()
    {
        $this->forge->shouldReceive()
            ->deleteCertificate('12345', '6789', '13579');

        $this->command(Delete::class)
            ->execute([
                'server' => '12345',
                'site' => '6789',
                'certificate' => '13579',
                '--force' => true,
            ]);
    }

    /** @test */
    public function it_does_not_delete_a_certificate_if_no_is_answered()
    {
        $this->forge->shouldNotReceive()
            ->deleteCertificate();

        $tester = $this->command(Delete::class)->setInputs(['no']);

        $tester->execute([
            'server' => '12345',
            'site' => '6789',
            'certificate' => '13579',
        ]);

        $this->assertStringContainsString('Command Cancelled!', $tester->getDisplay());
    }
}
