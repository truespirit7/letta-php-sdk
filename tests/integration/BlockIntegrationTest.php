<?php
namespace Tests\Integration;

use Letta\Client;

class BlockIntegrationTest extends IntegrationTestCase
{
    private $createdBlockIds = [];

    protected function tearDown(): void
    {
        $this->skipIfMissingEnv();
        $client = new Client([
            'base_uri' => self::$apiUrl,
            'token' => self::$apiToken,
        ]);
        foreach ($this->createdBlockIds as $blockId) {
            try {
                $client->blocks()->delete($blockId);
            } catch (\Exception $e) {
                // Ignore if already deleted
            }
        }
        $this->createdBlockIds = [];
    }

    public function testCreateFetchAndDeleteBlock()
    {
        $this->skipIfMissingEnv();
        $client = new Client([
            'base_uri' => self::$apiUrl,
            'token' => self::$apiToken,
        ]);
        $block = $client->blocks()->create([
            'label' => 'test_block_' . uniqid(),
            'value' => 'Integration test block',
            'limit' => 1000,
        ]);
        $this->assertNotNull($block);
        $this->createdBlockIds[] = $block->id;
        $fetched = $client->blocks()->get($block->id);
        $this->assertEquals($block->id, $fetched->id);
    }
} 