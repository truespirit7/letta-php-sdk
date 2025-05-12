<?php
namespace Tests\Integration;

use Letta\Client;

class IdentityIntegrationTest extends IntegrationTestCase
{
    private $createdIdentityIds = [];

    protected function tearDown(): void
    {
        $this->skipIfMissingEnv();
        $client = new Client([
            'base_uri' => self::$apiUrl,
            'token' => self::$apiToken,
        ]);
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
        $client = new Client([
            'base_uri' => self::$apiUrl,
            'token' => self::$apiToken,
        ]);
        $identity = $client->identities()->create([
            'name' => 'test_identity_' . uniqid(),
            'description' => 'Integration test identity',
        ]);
        $this->assertNotNull($identity);
        $this->createdIdentityIds[] = $identity->id;
        $fetched = $client->identities()->get($identity->id);
        $this->assertEquals($identity->id, $fetched->id);
    }
} 