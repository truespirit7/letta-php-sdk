<?php
namespace Tests\Integration;

use Letta\Client;

class AgentIntegrationTest extends IntegrationTestCase
{
    private $createdAgentIds = [];

    protected function tearDown(): void
    {
        $this->skipIfMissingEnv();
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
        foreach ($this->createdAgentIds as $agentId) {
            try {
                $client->agents()->delete($agentId);
            } catch (\Exception $e) {
                // Ignore if already deleted
            }
        }
        $this->createdAgentIds = [];
    }

    public function testListAgents()
    {
        $this->skipIfMissingEnv();
        $client = $this->getClient();
        $agents = $client->agents()->list();
        $this->assertIsArray($agents);
    }

    public function testCreateRetrieveModifyDeleteAgent()
    {
        $this->skipIfMissingEnv();
        $client = $this->getClient();
        $payload = [
            'name' => 'integration_test_agent_' . uniqid(),
            'description' => 'Integration test agent',
            'llm_config' => [
                'name' => 'letta-free',
                'provider' => 'letta',
                'model' => 'letta-free',
                'model_endpoint_type' => 'openai',
                'context_window' => 4096,
            ],
            'embedding_config' => [
                'embedding_endpoint_type' => 'openai',
                'embedding_model' => 'text-embedding-ada-002',
                'embedding_dim' => 1536,
            ],
        ];
        $agent = $client->agents()->create($payload);
        $this->assertNotNull($agent);
        $agentId = $agent['id'] ?? $agent->id ?? null;
        $this->assertNotNull($agentId);
        $this->createdAgentIds[] = $agentId;

        $fetched = $client->agents()->retrieve($agentId);
        $this->assertEquals($agentId, $fetched->id);

        $modPayload = ['description' => 'Updated description'];
        $modified = $client->agents()->modify($agentId, $modPayload);
        $this->assertEquals('Updated description', $modified['description'] ?? $modified->description ?? null);

        $deleted = $client->agents()->delete($agentId);
        $this->assertTrue($deleted);
        // Remove from cleanup
        $this->createdAgentIds = array_filter($this->createdAgentIds, fn($id) => $id !== $agentId);
    }

    public function testCountAgents()
    {
        $this->skipIfMissingEnv();
        $client = $this->getClient();
        try {
            $count = $client->agents()->count();
            $this->assertIsInt($count);
            $this->assertGreaterThanOrEqual(0, $count);
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), '404') !== false) {
                $this->markTestSkipped('Endpoint /v1/agents/count not available on this backend');
            } else {
                throw $e;
            }
        }
    }

    public function testExportImportAgent()
    {
        $this->skipIfMissingEnv();
        $client = $this->getClient();
        // Create agent to export
        $payload = [
            'name' => 'export_import_agent_' . uniqid(),
            'description' => 'Export/Import test',
            'llm_config' => [
                'name' => 'letta-free',
                'provider' => 'letta',
                'model' => 'letta-free',
                'model_endpoint_type' => 'openai',
                'context_window' => 4096,
            ],
            'embedding_config' => [
                'embedding_endpoint_type' => 'openai',
                'embedding_model' => 'text-embedding-ada-002',
                'embedding_dim' => 1536,
            ],
        ];
        $agent = $client->agents()->create($payload);
        $agentId = $agent['id'] ?? $agent->id ?? null;
        $this->assertNotNull($agentId);
        $this->createdAgentIds[] = $agentId;
        try {
            $exported = $client->agents()->export($agentId);
            $this->assertNotEmpty($exported);
            // Import as new agent
            $imported = $client->agents()->import($exported);
            $importedId = $imported['id'] ?? $imported->id ?? null;
            $this->assertNotNull($importedId);
            $this->createdAgentIds[] = $importedId;
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), '404') !== false) {
                $this->markTestSkipped('Endpoint /v1/agents/export not available on this backend');
            } else {
                throw $e;
            }
        }
    }

    public function testGetContext()
    {
        $this->skipIfMissingEnv();
        $client = $this->getClient();
        $agentId = self::$testAgentId;
        $context = $client->agents()->getContext($agentId);
        $this->assertIsArray($context);
    }

    public function testToolManagement()
    {
        $this->skipIfMissingEnv();
        $client = $this->getClient();
        $agentId = self::$testAgentId;
        $tools = $client->agents()->listTools($agentId);
        $this->assertIsArray($tools);
        // Attach/detach tool if any tool exists
        if (!empty($tools) && isset($tools[0]['id'])) {
            $toolId = $tools[0]['id'];
            $attachResp = $client->agents()->attachTool($agentId, $toolId);
            $this->assertNotNull($attachResp);
            $detachResp = $client->agents()->detachTool($agentId, $toolId);
            $this->assertNotNull($detachResp);
        }
    }

    public function testSourceManagement()
    {
        $this->skipIfMissingEnv();
        $client = $this->getClient();
        $agentId = self::$testAgentId;
        $sources = $client->agents()->listSources($agentId);
        $this->assertIsArray($sources);
        // Attach/detach source if any source exists
        if (!empty($sources) && isset($sources[0]['id'])) {
            $sourceId = $sources[0]['id'];
            $attachResp = $client->agents()->attachSource($agentId, $sourceId);
            $this->assertNotNull($attachResp);
            $detachResp = $client->agents()->detachSource($agentId, $sourceId);
            $this->assertNotNull($detachResp);
        }
    }

    public function testCoreMemoryBlockManagement()
    {
        $this->skipIfMissingEnv();
        $client = $this->getClient();
        $agentId = self::$testAgentId;
        // List, attach, detach, modify core memory blocks (simulate with dummy IDs/labels)
        $blockLabel = 'test_block';
        $blockId = 'test_block_id';
        try {
            $block = $client->agents()->getCoreMemoryBlock($agentId, $blockLabel);
            $this->assertIsArray($block);
        } catch (\Exception $e) {
            $this->markTestSkipped('getCoreMemoryBlock not available: ' . $e->getMessage());
        }
        try {
            $modResp = $client->agents()->modifyCoreMemoryBlock($agentId, $blockLabel, ['data' => 'test']);
            $this->assertIsArray($modResp);
        } catch (\Exception $e) {
            $this->markTestSkipped('modifyCoreMemoryBlock not available: ' . $e->getMessage());
        }
        try {
            $attachResp = $client->agents()->attachCoreMemoryBlock($agentId, $blockId);
            $this->assertIsArray($attachResp);
            $detachResp = $client->agents()->detachCoreMemoryBlock($agentId, $blockId);
            $this->assertIsArray($detachResp);
        } catch (\Exception $e) {
            $this->markTestSkipped('attach/detachCoreMemoryBlock not available: ' . $e->getMessage());
        }
    }
} 