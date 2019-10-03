<?php

namespace Sven\ForgeCLI\Tests\Commands;

use Sven\ForgeCLI\Commands\FirewallRules\Delete;
use Sven\ForgeCLI\Tests\TestCase;

class FirewallRulesTest extends TestCase
{
    /** @test */
    public function it_deletes_a_firewall_rule()
    {
        $this->forge->shouldReceive()
            ->deleteFirewallRule('12345', '6789');

        $this->command(Delete::class)
            ->setInputs(['yes'])
            ->execute([
                'server' => '12345',
                'rule' => '6789',
            ]);
    }

    /** @test */
    public function it_forces_deletition_of_a_firewall_rule()
    {
        $this->forge->shouldReceive()
            ->deleteFirewallRule('12345', '6789');

        $this->command(Delete::class)
            ->execute([
                'server' => '12345',
                'rule' => '6789',
                '--force' => true,
            ]);
    }

    /** @test */
    public function it_does_not_delete_a_firewall_rule_if_no_is_answered()
    {
        $this->forge->shouldNotReceive()
            ->deleteFirewallRule();

        $tester = $this->command(Delete::class)->setInputs(['no']);

        $tester->execute([
            'server' => '12345',
            'rule' => '6789',
        ]);

        $this->assertStringContainsString('Command Cancelled!', $tester->getDisplay());
    }
}
