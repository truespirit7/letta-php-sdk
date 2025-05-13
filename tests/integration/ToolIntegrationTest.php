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
            'source_code' => "def add(a: int, b: int) -> int:\n    \"\"\"\n    Add two numbers.\n    Args:\n        a (int): First number.\n        b (int): Second number.\n    Returns:\n        int: The sum.\n    \"\"\"\n    return a + b\n\njson_schema = {\n    'type': 'object',\n    'properties': {\n        'a': {'type': 'integer', 'description': 'First number.'},\n        'b': {'type': 'integer', 'description': 'Second number.'}\n    },\n    'required': ['a', 'b']\n}\n"
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