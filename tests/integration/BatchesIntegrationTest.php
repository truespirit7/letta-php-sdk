<?php
namespace Tests\Integration;

use Letta\Client;

class BatchesIntegrationTest extends IntegrationTestCase
{
    public function testListBatchRuns()
    {
        $this->skipIfMissingEnv();
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
        $runs = $client->batches()->listRuns();
        echo "\n[DEBUG] Batch runs:\n" . json_encode($runs, JSON_PRETTY_PRINT) . "\n";
        $this->assertIsArray($runs);
    }
} 