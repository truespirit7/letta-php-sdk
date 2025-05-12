<?php
namespace Tests\Integration;

use Letta\Client;

class TemplatesIntegrationTest extends IntegrationTestCase
{
    public function testListTemplates()
    {
        $this->skipIfMissingEnv();
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
        $templates = $client->templates()->list();
        echo "\n[DEBUG] Templates:\n" . json_encode($templates, JSON_PRETTY_PRINT) . "\n";
        $this->assertIsArray($templates);
    }
} 