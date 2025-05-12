<?php
namespace Tests\Integration;

use Letta\Client;

class GroupsIntegrationTest extends IntegrationTestCase
{
    private $createdGroupIds = [];

    protected function tearDown(): void
    {
        $this->skipIfMissingEnv();
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
        foreach ($this->createdGroupIds as $groupId) {
            try {
                $client->groups()->delete($groupId);
            } catch (\Exception $e) {
                // Ignore if already deleted
            }
        }
        $this->createdGroupIds = [];
    }

    public function testCreateFetchAndDeleteGroup()
    {
        $this->skipIfMissingEnv();
        $client = new Client(
            self::$apiToken,
            self::$apiUrl
        );
        $payload = [
            'name' => 'test_group_' . uniqid(),
            'description' => 'Integration test group',
            'agent_ids' => [self::$testAgentId],
        ];
        echo "\n[DEBUG] Group creation payload:\n" . json_encode($payload, JSON_PRETTY_PRINT) . "\n";
        try {
            $group = $client->groups()->create($payload);
            $this->assertNotNull($group);
            $this->createdGroupIds[] = $group->id;
            $fetched = $client->groups()->retrieve($group->id);
            $this->assertEquals($group->id, $fetched->id);
        } catch (\Exception $e) {
            echo "[ERROR] Exception during group creation: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
} 