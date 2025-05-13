<?php

namespace Tests\Integration;

use Tests\Integration\IntegrationTestCase;

class RunsUsageIntegrationTest extends IntegrationTestCase
{
    public function testRunUsage()
    {
        $client = $this->getClient();
        $runs = $client->runs()->list();
        echo "\n[DEBUG] Runs list:\n" . json_encode($runs, JSON_PRETTY_PRINT) . "\n";
        $this->assertIsArray($runs);

        if (empty($runs)) {
            echo "[INFO] No runs available for usage test.\n";
            $this->markTestSkipped('No runs available for usage test.');
            return;
        }

        $run = $runs[0];
        $this->assertArrayHasKey('id', (array)$run);
        $usage = $client->runs()->usage($run->id);
        echo "\n[DEBUG] Run usage:\n" . json_encode($usage, JSON_PRETTY_PRINT) . "\n";
        $this->assertIsArray($usage);
    }
} 