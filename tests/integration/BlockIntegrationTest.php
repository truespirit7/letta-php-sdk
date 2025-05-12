<?php
namespace Tests\Integration;

use Letta\Client;

class BlockIntegrationTest extends IntegrationTestCase
{
    private $createdBlockIds = [];

    protected function tearDown(): void
    {
        $this->skipIfMissingEnv();
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
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
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
        $payload = [
            'label' => 'test_block_' . uniqid(),
            'value' => 'Integration test block content',
        ];
        echo "\n[DEBUG] Block creation payload:\n" . json_encode($payload, JSON_PRETTY_PRINT) . "\n";
        try {
            $block = $client->blocks()->create($payload);
            $this->assertNotNull($block);
            $this->createdBlockIds[] = $block->id;
            $fetched = $client->blocks()->retrieve($block->id);
            $this->assertEquals($block->id, $fetched->id);
        } catch (\Exception $e) {
            echo "[ERROR] Exception during block creation: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
} 