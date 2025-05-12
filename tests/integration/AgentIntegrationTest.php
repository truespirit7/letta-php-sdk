<?php
namespace Tests\Integration;

use Letta\Client;

class AgentIntegrationTest extends IntegrationTestCase
{
    public function testCanFetchTestAgent()
    {
        $this->skipIfMissingEnv();
        $client = new Client([
            'base_uri' => self::$apiUrl,
            'token' => self::$apiToken,
        ]);
        $agent = $client->agents()->get(self::$testAgentId);
        $this->assertNotNull($agent);
        $this->assertEquals(self::$testAgentId, $agent->id);
    }
} 