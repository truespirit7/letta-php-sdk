<?php

namespace Tests\Integration;

use Tests\Integration\IntegrationTestCase;

class BatchesGlobalMessagesIntegrationTest extends IntegrationTestCase
{
    public function testListBatchMessages()
    {
        $client = $this->getClient();
        try {
            $result = $client->batches()->listBatchMessages('dummy_batch_id');
            echo "\n[DEBUG] listBatchMessages result:\n" . json_encode($result, JSON_PRETTY_PRINT) . "\n";
            $this->assertIsArray($result);
        } catch (\Exception $e) {
            echo "[INFO] Global batch messages endpoint not available: " . $e->getMessage() . "\n";
            $this->markTestSkipped('Global batch messages endpoint not available.');
        }
    }
} 