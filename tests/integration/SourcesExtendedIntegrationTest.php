<?php

namespace Tests\Integration;

use Tests\Integration\IntegrationTestCase;

class SourcesExtendedIntegrationTest extends IntegrationTestCase
{
    private $createdSourceId;
    private $uploadedFileId;
    private $tempFilePath;

    protected function tearDown(): void
    {
        $client = $this->getClient();
        if ($this->uploadedFileId && $this->createdSourceId) {
            try {
                $client->sources()->deleteFile($this->createdSourceId, $this->uploadedFileId);
            } catch (\Exception $e) {}
        }
        if ($this->createdSourceId) {
            try {
                $client->sources()->delete($this->createdSourceId);
            } catch (\Exception $e) {}
        }
        if ($this->tempFilePath && file_exists($this->tempFilePath)) {
            unlink($this->tempFilePath);
        }
    }

    public function testListFilesAndUploadAndDeleteFile()
    {
        $client = $this->getClient();
        // Create a source
        $payload = [
            'name' => 'test_source_' . uniqid(),
            'embedding' => 'openai/text-embedding-ada-002',
        ];
        $source = $client->sources()->create($payload);
        $this->createdSourceId = $source->id;
        // List files (should be empty)
        $files = $client->sources()->listFiles($source->id);
        $this->assertIsArray($files);
        // Ensure temp_test.pdf exists
        $pdfPath = __DIR__ . '/../../temp_test.pdf';
        $pdfBytes = base64_decode(
            'JVBERi0xLjEKMSAwIG9iago8PC9UeXBlL0NhdGFsb2cvUGFnZXMgMiAwIFI+PmVuZG9iagoyIDAgb2JqCjw8L1R5cGUvUGFnZXMvQ291bnQgMS9LaWRzWzMgMCBSXT4+ZW5kb2JqCjMgMCBvYmoKPDwvVHlwZS9QYWdlL1BhcmVudCAyIDAgUi9NZWRpYUJveFswIDAgMjAwIDIwMF0vQ29udGVudHMgNCAwIFIvUmVzb3VyY2VzPDwvRm9udDw8L0YxIDUgMCBSPj4+Pj4+ZW5kb2JqCjQgMCBvYmoKPDwvTGVuZ3RoIDQ0Pj5zdHJlYW0KQlQvRjEgMjQgVGYgMTAwIDEwMCBUZCAoSGVsbG8gUERGKSBUaiBFVAplbmRzdHJlYW0KZW5kb2JqCjUgMCBvYmoKPDwvVHlwZS9Gb250L1N1YnR5cGUvVHlwZTEvQmFzZUZvbnQvSGVsdmV0aWNhPj5lbmRvYmoKeHJlZgowIDYKMDAwMDAwMDAwMCA2NTUzNSBmCjAwMDAwMDAxMCAwMDAwMCBuCjAwMDAwMDA3OSAwMDAwMCBuCjAwMDAwMDE3OCAwMDAwMCBuCjAwMDAwMDMzNCAwMDAwMCBuCjAwMDAwMDQyMSAwMDAwMCBuCnRyYWlsZXI8PC9TaXplIDYvUm9vdCAxIDAgUj4+c3RhcnR4cmVmCjQ5NwplbmRvZmoK' // base64 for a minimal valid PDF
        );
        file_put_contents($pdfPath, $pdfBytes);
        $this->tempFilePath = $pdfPath;
        // Upload a file
        $uploadResult = $client->sources()->uploadFile($source->id, $this->tempFilePath);
        echo "\n[DEBUG] Upload result:\n" . json_encode($uploadResult, JSON_PRETTY_PRINT) . "\n";
        $this->assertArrayHasKey('id', (array)$uploadResult);
        $jobId = $uploadResult['id'] ?? $uploadResult->id ?? null;
        $this->assertNotNull($jobId, 'Job ID not found in upload result');
        // Poll job status until completed (max 30s)
        $jobCompleted = false;
        $maxWait = 30;
        $waited = 0;
        $jobMetadata = null;
        while ($waited < $maxWait) {
            sleep(2);
            $waited += 2;
            $job = $client->jobs()->retrieve($jobId);
            $jobStatus = $job['status'] ?? $job->status ?? null;
            $jobMetadata = $job['metadata'] ?? $job->metadata ?? null;
            echo "[DEBUG] Job status after {$waited}s: {$jobStatus}\n";
            if ($jobStatus === 'completed') {
                break;
            }
        }
        echo "[DEBUG] Job metadata after completion: " . json_encode($jobMetadata, JSON_PRETTY_PRINT) . "\n";
        $this->assertTrue(($jobStatus === 'completed'), 'File upload job did not complete in time');
        // List files again and get the new file's ID, retry up to 5 times
        $fileId = null;
        for ($retry = 0; $retry < 5; $retry++) {
            $filesAfter = $client->sources()->listFiles($source->id);
            echo "[DEBUG] File list after retry {$retry}: " . json_encode($filesAfter, JSON_PRETTY_PRINT) . "\n";
            foreach ($filesAfter as $file) {
                $fname = $file['file_name'] ?? $file->file_name ?? '';
                if (str_starts_with($fname, 'temp_test') && str_ends_with($fname, '.pdf')) {
                    $fileId = $file['id'] ?? $file->id ?? null;
                    break 2;
                }
            }
            if ($retry < 4) {
                echo "[DEBUG] Uploaded file not found, retrying file list...\n";
                sleep(2);
            }
        }
        $this->assertNotNull($fileId, 'Uploaded file not found in file list');
        $this->uploadedFileId = $fileId;
        // Wait before deletion
        sleep(10);
        // Print file list and IDs before deletion
        $filesBeforeDelete = $client->sources()->listFiles($source->id);
        echo "[DEBUG] File list before deletion: " . json_encode($filesBeforeDelete, JSON_PRETTY_PRINT) . "\n";
        echo "[DEBUG] Deleting file with source_id={$source->id} file_id={$this->uploadedFileId}\n";
        // Delete the file
        try {
            $deleteResult = $client->sources()->deleteFile($source->id, $this->uploadedFileId);
            $this->assertTrue($deleteResult);
        } catch (\Exception $e) {
            echo "[DEBUG] Exception during delete: " . $e->getMessage() . "\n";
            // Print file status after failed delete
            $filesAfterDelete = $client->sources()->listFiles($source->id);
            echo "[DEBUG] File list after failed delete: " . json_encode($filesAfterDelete, JSON_PRETTY_PRINT) . "\n";
            throw $e;
        }
        $this->uploadedFileId = null;
        // List files again
        $filesFinal = $client->sources()->listFiles($source->id);
        $this->assertEmpty($filesFinal);
    }

    public function testListPassages()
    {
        $client = $this->getClient();
        // Create a source
        $source = $client->sources()->create([
            'name' => 'test_source_' . uniqid(),
            'embedding' => 'openai/text-embedding-ada-002',
        ]);
        $this->createdSourceId = $source->id;
        $passages = $client->sources()->listPassages($source->id);
        echo "\n[DEBUG] Passages list:\n" . json_encode($passages, JSON_PRETTY_PRINT) . "\n";
        $this->assertIsArray($passages);
    }
} 