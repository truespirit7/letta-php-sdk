<?php

namespace Tests\Integration;

use Tests\Integration\IntegrationTestCase;

class StepsIntegrationTest extends IntegrationTestCase
{
    public function testListAndRetrieveStep()
    {
        $client = $this->getClient();
        $steps = $client->steps()->list();
        echo "\n[DEBUG] Steps list:\n" . json_encode($steps, JSON_PRETTY_PRINT) . "\n";
        $this->assertIsArray($steps);

        if (empty($steps)) {
            echo "[INFO] No steps available to retrieve.\n";
            $this->markTestSkipped('No steps available for retrieve test.');
            return;
        }

        $step = $steps[0];
        $this->assertArrayHasKey('id', $step);
        $stepId = $step['id'];

        $retrieved = $client->steps()->retrieve($stepId);
        echo "[DEBUG] Retrieved step:\n" . json_encode($retrieved, JSON_PRETTY_PRINT) . "\n";
        $this->assertEquals($stepId, $retrieved['id']);
    }
} 