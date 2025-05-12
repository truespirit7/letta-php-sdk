<?php
namespace Tests\Integration;

use Letta\Client;

class TagsIntegrationTest extends IntegrationTestCase
{
    public function testListTags()
    {
        $this->skipIfMissingEnv();
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
        $tags = $client->tags()->list();
        echo "\n[DEBUG] Tags:\n" . json_encode($tags, JSON_PRETTY_PRINT) . "\n";
        $this->assertIsArray($tags);
    }
} 