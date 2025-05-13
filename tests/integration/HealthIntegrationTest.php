<?php

namespace Tests\Integration;

use Tests\Integration\IntegrationTestCase;

class HealthIntegrationTest extends IntegrationTestCase
{
    public function testHealthCheck()
    {
        $client = $this->getClient();
        $result = $client->health()->check();
        echo "\n[DEBUG] Health check response:\n" . json_encode($result, JSON_PRETTY_PRINT) . "\n";
        $this->assertIsArray($result);
        $this->assertArrayHasKey('status', $result);
        $this->assertEquals('ok', $result['status']);
    }
} 