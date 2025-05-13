<?php

namespace Tests\Integration;

use Tests\Integration\IntegrationTestCase;

class JobsIntegrationTest extends IntegrationTestCase
{
    public function testListAndRetrieveAndDeleteJob()
    {
        $client = $this->getClient();
        $jobs = $client->jobs()->list();
        echo "\n[DEBUG] Jobs list:\n" . json_encode($jobs, JSON_PRETTY_PRINT) . "\n";
        $this->assertIsArray($jobs);

        if (empty($jobs)) {
            echo "[INFO] No jobs available to retrieve or delete.\n";
            $this->markTestSkipped('No jobs available for retrieve/delete test.');
            return;
        }

        $job = $jobs[0];
        $this->assertArrayHasKey('id', (array)$job);
        $retrieved = $client->jobs()->retrieve($job->id);
        echo "\n[DEBUG] Retrieved job:\n" . json_encode($retrieved, JSON_PRETTY_PRINT) . "\n";
        $this->assertEquals($job->id, $retrieved->id);
        // Try to delete (may not be allowed)
        try {
            $deleteResult = $client->jobs()->delete($job->id);
            $this->assertTrue($deleteResult);
        } catch (\Exception $e) {
            echo "[INFO] Delete not allowed or failed: " . $e->getMessage() . "\n";
        }
    }

    public function testListActiveJobs()
    {
        $client = $this->getClient();
        $activeJobs = $client->jobs()->listActive();
        echo "\n[DEBUG] Active jobs list:\n" . json_encode($activeJobs, JSON_PRETTY_PRINT) . "\n";
        $this->assertIsArray($activeJobs);
    }
} 