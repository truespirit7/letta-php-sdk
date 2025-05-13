<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
use Letta\Client;

if (file_exists(__DIR__ . '/../../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
}

$apiUrl = $_ENV['LETTA_API_URL'] ?? null;
$apiToken = $_ENV['LETTA_API_TOKEN'] ?? null;

if (!$apiUrl || !$apiToken) {
    fwrite(STDERR, "Missing LETTA_API_URL or LETTA_API_TOKEN in environment.\n");
    exit(1);
}

$client = new Client($apiToken, $apiUrl);
$payload = [
    'name' => 'example_source_' . uniqid(),
    'embedding' => 'openai/text-embedding-ada-002',
];
$source = $client->sources()->create($payload);
echo "Created source:\n" . json_encode($source, JSON_PRETTY_PRINT) . "\n";

// Generate a minimal PDF file
$tempfile = tempnam(sys_get_temp_dir(), 'letta_pdf_') . '.pdf';
$pdfBytes = base64_decode('JVBERi0xLjEKMSAwIG9iago8PC9UeXBlL0NhdGFsb2cvUGFnZXMgMiAwIFI+PmVuZG9iagoyIDAgb2JqCjw8L1R5cGUvUGFnZXMvQ291bnQgMS9LaWRzWzMgMCBSXT4+ZW5kb2JqCjMgMCBvYmoKPDwvVHlwZS9QYWdlL1BhcmVudCAyIDAgUi9NZWRpYUJveFswIDAgMjAwIDIwMF0vQ29udGVudHMgNCAwIFIvUmVzb3VyY2VzPDwvRm9udDw8L0YxIDUgMCBSPj4+Pj4+ZW5kb2JqCjQgMCBvYmoKPDwvTGVuZ3RoIDQ0Pj5zdHJlYW0KQlQvRjEgMjQgVGYgMTAwIDEwMCBUZCAoSGVsbG8gUERGKSBUaiBFVAplbmRzdHJlYW0KZW5kb2JqCjUgMCBvYmoKPDwvVHlwZS9Gb250L1N1YnR5cGUvVHlwZTEvQmFzZUZvbnQvSGVsdmV0aWNhPj5lbmRvYmoKeHJlZgowIDYKMDAwMDAwMDAwMCA2NTUzNSBmCjAwMDAwMDAxMCAwMDAwMCBuCjAwMDAwMDA3OSAwMDAwMCBuCjAwMDAwMDE3OCAwMDAwMCBuCjAwMDAwMDMzNCAwMDAwMCBuCjAwMDAwMDQyMSAwMDAwMCBuCnRyYWlsZXI8PC9TaXplIDYvUm9vdCAxIDAgUj4+c3RhcnR4cmVmCjQ5NwplbmRvZmoK');
file_put_contents($tempfile, $pdfBytes);
echo "Generated PDF at $tempfile\n";

// Upload the file
$uploadResult = $client->sources()->uploadFile($source->id, $tempfile);
echo "Upload result:\n" . json_encode($uploadResult, JSON_PRETTY_PRINT) . "\n";
$jobId = $uploadResult['id'] ?? $uploadResult->id ?? null;
if (!$jobId) {
    echo "[ERROR] No job ID found in upload result.\n";
    exit(1);
}

// Poll job status until completed (max 30s)
$maxWait = 30;
$waited = 0;
while ($waited < $maxWait) {
    sleep(2);
    $waited += 2;
    $job = $client->jobs()->retrieve($jobId);
    $jobStatus = $job['status'] ?? $job->status ?? null;
    echo "Job status after {$waited}s: {$jobStatus}\n";
    if ($jobStatus === 'completed') {
        break;
    }
}
if ($jobStatus !== 'completed') {
    echo "[ERROR] File upload job did not complete in time.\n";
    exit(1);
}

// List files and find the uploaded file
$fileId = null;
$files = $client->sources()->listFiles($source->id);
echo "Files after upload:\n" . json_encode($files, JSON_PRETTY_PRINT) . "\n";
foreach ($files as $file) {
    $fname = $file['file_name'] ?? $file->file_name ?? '';
    if (str_starts_with($fname, basename($tempfile))) {
        $fileId = $file['id'] ?? $file->id ?? null;
        break;
    }
}
if (!$fileId) {
    echo "[ERROR] Uploaded file not found in file list.\n";
    exit(1);
}
echo "Found uploaded file with ID: $fileId\n";

// Delete the uploaded file
$deleted = $client->sources()->deleteFile($source->id, $fileId);
echo "Deleted file result: ";
var_dump($deleted);

// Cleanup temp file
unlink($tempfile); 