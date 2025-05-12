<?php
namespace Tests\Integration;

use Letta\Client;

class VoiceIntegrationTest extends IntegrationTestCase
{
    public function testCreateVoiceChatCompletion()
    {
        $this->skipIfMissingEnv();
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
        $payload = [
            'messages' => [
                ['role' => 'user', 'content' => 'Say hello!']
            ],
            'voice' => 'default',
            'language' => 'en',
        ];
        echo "\n[DEBUG] Voice chat completion payload:\n" . json_encode($payload, JSON_PRETTY_PRINT) . "\n";
        try {
            $response = $client->voice()->createVoiceChatCompletion($payload);
            echo "[DEBUG] Voice chat completion response:\n" . json_encode($response, JSON_PRETTY_PRINT) . "\n";
            $this->assertNotEmpty($response);
        } catch (\Exception $e) {
            echo "[ERROR] Exception during voice chat completion: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
} 