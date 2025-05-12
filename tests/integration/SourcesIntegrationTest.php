<?php
namespace Tests\Integration;

use Letta\Client;

class SourcesIntegrationTest extends IntegrationTestCase
{
    private $createdSourceIds = [];

    protected function tearDown(): void
    {
        $this->skipIfMissingEnv();
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
        foreach ($this->createdSourceIds as $sourceId) {
            try {
                $client->sources()->delete($sourceId);
            } catch (\Exception $e) {
                // Ignore if already deleted
            }
        }
        $this->createdSourceIds = [];
    }

    public function testCreateFetchAndDeleteSource()
    {
        $this->skipIfMissingEnv();
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
        $payload = [
            'name' => 'test_source_' . uniqid(),
            'description' => 'Integration test source',
            'embedding' => 'openai/text-embedding-ada-002',
        ];
        echo "\n[DEBUG] Source creation payload:\n" . json_encode($payload, JSON_PRETTY_PRINT) . "\n";
        try {
            $source = $client->sources()->create($payload);
            $this->assertNotNull($source);
            $this->createdSourceIds[] = $source->id;
            $fetched = $client->sources()->retrieve($source->id);
            $this->assertEquals($source->id, $fetched->id);
        } catch (\Exception $e) {
            echo "[ERROR] Exception during source creation: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
} 