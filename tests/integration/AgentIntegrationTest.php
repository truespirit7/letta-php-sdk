<?php
namespace Tests\Integration;

use Letta\Client;

class AgentIntegrationTest extends IntegrationTestCase
{
    public function testCanFetchTestAgent()
    {
        $this->skipIfMissingEnv();
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
        $agent = $client->agents()->retrieve(self::$testAgentId);
        $this->assertNotNull($agent);
        $this->assertEquals(self::$testAgentId, $agent->id);
    }
} 