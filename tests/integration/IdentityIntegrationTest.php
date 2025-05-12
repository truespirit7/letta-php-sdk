<?php
namespace Tests\Integration;

use Letta\Client;

class IdentityIntegrationTest extends IntegrationTestCase
{
    private $createdIdentityIds = [];

    protected function tearDown(): void
    {
        $this->skipIfMissingEnv();
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
        foreach ($this->createdIdentityIds as $identityId) {
            try {
                $client->identities()->delete($identityId);
            } catch (\Exception $e) {
                // Ignore if already deleted
            }
        }
        $this->createdIdentityIds = [];
    }

    public function testCreateFetchAndDeleteIdentity()
    {
        $this->skipIfMissingEnv();
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
        $payload = [
            'name' => 'test_identity_' . uniqid(),
            'identifier_key' => 'test_identity_' . uniqid(),
            'identity_type' => 'user',
        ];
        echo "\n[DEBUG] Identity creation payload:\n" . json_encode($payload, JSON_PRETTY_PRINT) . "\n";
        try {
            $identity = $client->identities()->create($payload);
            $this->assertNotNull($identity);
            $this->createdIdentityIds[] = $identity->id;
            $fetched = $client->identities()->retrieve($identity->id);
            $this->assertEquals($identity->id, $fetched->id);
        } catch (\Exception $e) {
            echo "[ERROR] Exception during identity creation: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
} 