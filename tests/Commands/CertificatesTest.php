<?php

namespace Sven\ForgeCLI\Tests\Commands;

use Sven\ForgeCLI\Commands\Certificates\Activate;
use Sven\ForgeCLI\Commands\Certificates\MakeLetsEncrypt;
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

    /** @test */
    public function it_can_obtain_letsencrypt_certificates()
    {   
        $this->forge->shouldReceive()
            ->obtainLetsEncryptCertificate('12345', '67890', ['domains' => ['domain.com']], false)
            ->once()
            ->andReturn(
                new Certificate(['id' => '13579', 'serverId' => '12345', 'siteId' => '67890'])
            );

        $tester = $this->command(MakeLetsEncrypt::class);

        $tester->execute([
            'server' => '12345',
            'site' => '67890',
            '--domains' => 'domain.com',
        ]);

        $this->assertStringContainsString('13579', $tester->getDisplay());
    }

    /** @test */
    public function it_can_obtain_letsencrypt_certificate_with_multiple_domains()
    {   
        $this->forge->shouldReceive()
            ->obtainLetsEncryptCertificate('12345', '67890', ['domains' => ['domain.com', 'www.domain.com']], false)
            ->once()
            ->andReturn(
                new Certificate(['id' => '13579', 'serverId' => '12345', 'siteId' => '67890'])
            );

        $tester = $this->command(MakeLetsEncrypt::class);

        $tester->execute([
            'server' => '12345',
            'site' => '67890',
            '--domains' => 'domain.com,www.domain.com',
        ]);

        $this->assertStringContainsString('13579', $tester->getDisplay());
    }
}
