<?php
namespace Tests\Integration;

use Letta\Client;

class ProvidersIntegrationTest extends IntegrationTestCase
{
    public function testListProviders()
    {
        $this->skipIfMissingEnv();
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
        $providers = $client->providers()->list();
        echo "\n[DEBUG] Providers:\n" . json_encode($providers, JSON_PRETTY_PRINT) . "\n";
        $this->assertIsArray($providers);
    }
} 