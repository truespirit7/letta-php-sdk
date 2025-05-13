<?php

namespace Tests\Integration;

use Tests\Integration\IntegrationTestCase;

class RunsIntegrationTest extends IntegrationTestCase
{
    public function testListAndRetrieveAndDeleteRun()
    {
        $client = $this->getClient();
        $runs = $client->runs()->list();
        echo "\n[DEBUG] Runs list:\n" . json_encode($runs, JSON_PRETTY_PRINT) . "\n";
        $this->assertIsArray($runs);

        if (empty($runs)) {
            echo "[INFO] No runs available to retrieve or delete.\n";
            $this->markTestSkipped('No runs available for retrieve/delete test.');
            return;
        }

        $run = $runs[0];
        $this->assertArrayHasKey('id', $run);
        $runId = $run['id'];

        $retrieved = $client->runs()->retrieve($runId);
        echo "[DEBUG] Retrieved run:\n" . json_encode($retrieved, JSON_PRETTY_PRINT) . "\n";
        $this->assertEquals($runId, $retrieved['id']);

        $deleteResponse = $client->runs()->delete($runId);
        echo "[DEBUG] Delete response:\n" . json_encode($deleteResponse, JSON_PRETTY_PRINT) . "\n";
        // The delete endpoint may return empty or confirmation; just check no error
        $this->assertTrue(is_array($deleteResponse) || $deleteResponse === null || $deleteResponse === '');
    }

    public function testListActiveRuns()
    {
        $client = $this->getClient();
        $activeRuns = $client->runs()->listActive();
        echo "\n[DEBUG] Active runs:\n" . json_encode($activeRuns, JSON_PRETTY_PRINT) . "\n";
        $this->assertIsArray($activeRuns);
    }
} 