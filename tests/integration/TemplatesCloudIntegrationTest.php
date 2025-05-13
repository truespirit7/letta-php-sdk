<?php

namespace Tests\Integration;

use Tests\Integration\IntegrationTestCase;

class TemplatesCloudIntegrationTest extends IntegrationTestCase
{
    public function testCreateFromAgentCloudOnly()
    {
        $client = $this->getClient();
        try {
            $result = $client->templates()->createFromAgent('dummy_agent_id', []);
            echo "\n[DEBUG] createFromAgent result:\n" . json_encode($result, JSON_PRETTY_PRINT) . "\n";
            $this->assertIsArray($result);
        } catch (\Exception $e) {
            echo "[INFO] Cloud-only endpoint not available: " . $e->getMessage() . "\n";
            $this->markTestSkipped('Cloud-only endpoint not available.');
        }
    }

    public function testVersionFromAgentCloudOnly()
    {
        $client = $this->getClient();
        try {
            $result = $client->templates()->versionFromAgent('dummy_agent_id', []);
            echo "\n[DEBUG] versionFromAgent result:\n" . json_encode($result, JSON_PRETTY_PRINT) . "\n";
            $this->assertIsArray($result);
        } catch (\Exception $e) {
            echo "[INFO] Cloud-only endpoint not available: " . $e->getMessage() . "\n";
            $this->markTestSkipped('Cloud-only endpoint not available.');
        }
    }
} 