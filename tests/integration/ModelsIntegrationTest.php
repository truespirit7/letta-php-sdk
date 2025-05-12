<?php
namespace Tests\Integration;

use Letta\Client;

class ModelsIntegrationTest extends IntegrationTestCase
{
    public function testListModels()
    {
        $this->skipIfMissingEnv();
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
        $models = $client->models()->list();
        echo "\n[DEBUG] Models:\n" . json_encode($models, JSON_PRETTY_PRINT) . "\n";
        $this->assertIsArray($models);
        $this->assertNotEmpty($models);
    }

    public function testListEmbeddingModels()
    {
        $this->skipIfMissingEnv();
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
        $embeddingModels = $client->models()->listEmbeddingModels();
        echo "\n[DEBUG] Embedding models:\n" . json_encode($embeddingModels, JSON_PRETTY_PRINT) . "\n";
        $this->assertIsArray($embeddingModels);
        $this->assertNotEmpty($embeddingModels);
    }
} 