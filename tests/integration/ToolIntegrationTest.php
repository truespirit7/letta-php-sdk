<?php
namespace Tests\Integration;

use Letta\Client;

class ToolIntegrationTest extends IntegrationTestCase
{
    private $createdToolIds = [];

    protected function tearDown(): void
    {
        $this->skipIfMissingEnv();
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
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
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
        $payload = [
            'name' => 'test_tool_' . uniqid(),
            'description' => 'Integration test tool',
            'tool_type' => 'custom',
            'source_type' => 'python',
            'source_code' => 'def run(): return "ok"',
            'json_schema' => (object)[],
            'args_json_schema' => (object)[],
            'return_char_limit' => 100
        ];
        echo "\n[DEBUG] Tool creation payload:\n" . json_encode($payload, JSON_PRETTY_PRINT) . "\n";
        try {
            $tool = $client->tools()->upsert($payload);
            $this->assertNotNull($tool);
            $this->createdToolIds[] = $tool->id;
            $fetched = $client->tools()->retrieve($tool->id);
            $this->assertEquals($tool->id, $fetched->id);
        } catch (\Exception $e) {
            echo "[ERROR] Exception during tool creation: " . $e->getMessage() . "\n";
            if (method_exists($e, 'getResponse')) {
                $response = $e->getResponse();
                echo "[ERROR] API Response: " . print_r($response, true) . "\n";
            }
            throw $e;
        }
    }
} 