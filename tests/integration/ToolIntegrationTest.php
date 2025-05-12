<?php
namespace Tests\Integration;

use Letta\Client;

class ToolIntegrationTest extends IntegrationTestCase
{
    private $createdToolIds = [];

    protected function tearDown(): void
    {
        $this->skipIfMissingEnv();
        $client = new Client([
            'base_uri' => self::$apiUrl,
            'token' => self::$apiToken,
        ]);
        foreach ($this->createdToolIds as $toolId) {
            try {
                $client->tools()->delete($toolId);
            } catch (\Exception $e) {
                // Ignore if already deleted
            }
        }
        $this->createdToolIds = [];
    }

    public function testCreateFetchAndDeleteTool()
    {
        $this->skipIfMissingEnv();
        $client = new Client([
            'base_uri' => self::$apiUrl,
            'token' => self::$apiToken,
        ]);
        $tool = $client->tools()->create([
            'name' => 'test_tool_' . uniqid(),
            'description' => 'Integration test tool',
            'tool_type' => 'custom',
            'source_type' => 'python',
            'source_code' => 'def run(): return "ok"',
            'json_schema' => new \stdClass(),
            'args_json_schema' => new \stdClass(),
            'return_char_limit' => 100
        ]);
        $this->assertNotNull($tool);
        $this->createdToolIds[] = $tool->id;
        $fetched = $client->tools()->get($tool->id);
        $this->assertEquals($tool->id, $fetched->id);
    }
} 