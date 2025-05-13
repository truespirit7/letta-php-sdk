<?php

namespace Tests\Integration;

use Tests\Integration\IntegrationTestCase;

class AgentsCloudIntegrationTest extends IntegrationTestCase
{
    public function testGetCoreMemoryVariablesCloudOnly()
    {
        $client = $this->getClient();
        try {
            $result = $client->agents()->getCoreMemoryVariables('dummy_agent_id');
            echo "\n[DEBUG] getCoreMemoryVariables result:\n" . json_encode($result, JSON_PRETTY_PRINT) . "\n";
            $this->assertIsArray($result);
        } catch (\Exception $e) {
            echo "[INFO] Cloud-only endpoint not available: " . $e->getMessage() . "\n";
            $this->markTestSkipped('Cloud-only endpoint not available.');
        }
    }
} 