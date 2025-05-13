<?php

namespace Tests\Integration;

use Tests\Integration\IntegrationTestCase;

class ToolExtendedIntegrationTest extends IntegrationTestCase
{
    private $createdToolId;

    protected function tearDown(): void
    {
        if ($this->createdToolId) {
            try {
                $client = $this->getClient();
                $client->tools()->delete($this->createdToolId);
            } catch (\Exception $e) {
                // Ignore errors on cleanup
            }
        }
    }

    public function testRetrieveAndDeleteTool()
    {
        $client = $this->getClient();
        $tool = $client->tools()->create([
            'source_code' => "def add(a: int, b: int) -> int:\n    \"\"\"\n    Add two numbers.\n    Args:\n        a (int): First number.\n        b (int): Second number.\n    Returns:\n        int: The sum.\n    \"\"\"\n    return a + b\n\njson_schema = {\n    'type': 'object',\n    'properties': {\n        'a': {'type': 'integer', 'description': 'First number.'},\n        'b': {'type': 'integer', 'description': 'Second number.'}\n    },\n    'required': ['a', 'b']\n}\n"
        ]);
        $this->createdToolId = $tool->id;
        $retrieved = $client->tools()->retrieve($tool->id);
        echo "\n[DEBUG] Retrieved tool:\n" . json_encode($retrieved, JSON_PRETTY_PRINT) . "\n";
        $this->assertEquals($tool->id, $retrieved->id);
        $deleteResult = $client->tools()->delete($tool->id);
        $this->createdToolId = null;
        $this->assertTrue($deleteResult);
        // Confirm deletion
        try {
            $client->tools()->retrieve($tool->id);
            $this->fail('Tool should not exist after deletion');
        } catch (\Exception $e) {
            $this->assertStringContainsString('HTTP error', $e->getMessage());
        }
    }

    public function testUpdateTool()
    {
        $client = $this->getClient();
        $tool = $client->tools()->create([
            'source_code' => "def add(a: int, b: int) -> int:\n    \"\"\"\n    Add two numbers.\n    Args:\n        a (int): First number.\n        b (int): Second number.\n    Returns:\n        int: The sum.\n    \"\"\"\n    return a + b\n\njson_schema = {\n    'type': 'object',\n    'properties': {\n        'a': {'type': 'integer', 'description': 'First number.'},\n        'b': {'type': 'integer', 'description': 'Second number.'}\n    },\n    'required': ['a', 'b']\n}\n"
        ]);
        $this->createdToolId = $tool->id;
        $updated = $client->tools()->update($tool->id, [
            'description' => 'Updated description'
        ]);
        echo "\n[DEBUG] Updated tool:\n" . json_encode($updated, JSON_PRETTY_PRINT) . "\n";
        $this->assertEquals('Updated description', $updated->description);
    }

    public function testCountTools()
    {
        $client = $this->getClient();
        try {
            $countBefore = $client->tools()->count();
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), '404') !== false) {
                $this->markTestSkipped('tools/count endpoint not available on this server.');
                return;
            }
            throw $e;
        }
        $tool = $client->tools()->create([
            'source_code' => "def add(a: int, b: int) -> int:\n    \"\"\"\n    Add two numbers.\n    Args:\n        a (int): First number.\n        b (int): Second number.\n    Returns:\n        int: The sum.\n    \"\"\"\n    return a + b\n\njson_schema = {\n    'type': 'object',\n    'properties': {\n        'a': {'type': 'integer', 'description': 'First number.'},\n        'b': {'type': 'integer', 'description': 'Second number.'}\n    },\n    'required': ['a', 'b']\n}\n"
        ]);
        $this->createdToolId = $tool->id;
        $countAfter = $client->tools()->count();
        echo "\n[DEBUG] Tool count before: $countBefore, after: $countAfter\n";
        $this->assertEquals($countBefore + 1, $countAfter);
        $client->tools()->delete($tool->id);
        $this->createdToolId = null;
        $countFinal = $client->tools()->count();
        $this->assertEquals($countBefore, $countFinal);
    }
} 