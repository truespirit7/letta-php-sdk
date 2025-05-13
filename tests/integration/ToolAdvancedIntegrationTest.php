<?php
namespace Tests\Integration;

use Tests\Integration\IntegrationTestCase;

class ToolAdvancedIntegrationTest extends IntegrationTestCase
{
    public function testRunFromSource()
    {
        $client = $this->getClient();
        $payload = [
            'source_code' => "def add(a: int, b: int) -> int:\n    \"\"\"\n    Add two numbers.\n    Args:\n        a (int): First number.\n        b (int): Second number.\n    Returns:\n        int: The sum.\n    \"\"\"\n    return a + b\n\njson_schema = {\n    'type': 'object',\n    'properties': {\n        'a': {'type': 'integer', 'description': 'First number.'},\n        'b': {'type': 'integer', 'description': 'Second number.'}\n    },\n    'required': ['a', 'b']\n}\n"
        ];
        try {
            $result = $client->tools()->runFromSource($payload);
            echo "\n[DEBUG] runFromSource result:\n" . json_encode($result, JSON_PRETTY_PRINT) . "\n";
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), '404') !== false) {
                $this->markTestSkipped('runFromSource endpoint not available.');
                return;
            }
            throw $e;
        }
    }

    public function testUpsertBase()
    {
        $client = $this->getClient();
        $payload = [
            'source_code' => "def add(a: int, b: int) -> int:\n    \"\"\"\n    Add two numbers.\n    Args:\n        a (int): First number.\n        b (int): Second number.\n    Returns:\n        int: The sum.\n    \"\"\"\n    return a + b\n\njson_schema = {\n    'type': 'object',\n    'properties': {\n        'a': {'type': 'integer', 'description': 'First number.'},\n        'b': {'type': 'integer', 'description': 'Second number.'}\n    },\n    'required': ['a', 'b']\n}\n"
        ];
        try {
            $result = $client->tools()->upsertBase($payload);
            echo "\n[DEBUG] upsertBase result:\n" . json_encode($result, JSON_PRETTY_PRINT) . "\n";
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), '404') !== false) {
                $this->markTestSkipped('upsertBase endpoint not available.');
                return;
            }
            throw $e;
        }
    }

    public function testListMcpServers()
    {
        $this->markTestSkipped('MCP testing skipped by user request.');
    }

    public function testAddMcpServer()
    {
        $this->markTestSkipped('MCP testing skipped by user request.');
    }

    public function testListMcpTools()
    {
        $this->markTestSkipped('MCP testing skipped by user request.');
    }

    public function testAddMcpTool()
    {
        $this->markTestSkipped('MCP testing skipped by user request.');
    }

    public function testListComposioApps()
    {
        $this->markTestSkipped('Composio testing skipped by user request.');
    }

    public function testListComposioActions()
    {
        $this->markTestSkipped('Composio testing skipped by user request.');
    }

    public function testAddComposioTool()
    {
        $this->markTestSkipped('Composio testing skipped by user request.');
    }
} 