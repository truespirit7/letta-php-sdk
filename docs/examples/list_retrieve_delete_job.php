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
$jobs = $client->jobs()->list();
echo "Jobs list:\n" . json_encode($jobs, JSON_PRETTY_PRINT) . "\n";

if (empty($jobs)) {
    echo "[INFO] No jobs available to retrieve or delete.\n";
    exit(0);
}

$job = $jobs[0];
$jobId = $job['id'] ?? $job->id ?? null;
if (!$jobId) {
    echo "[ERROR] No job ID found in first job.\n";
    exit(1);
}

$retrieved = $client->jobs()->retrieve($jobId);
echo "Retrieved job:\n" . json_encode($retrieved, JSON_PRETTY_PRINT) . "\n";

try {
    $deleted = $client->jobs()->delete($jobId);
    echo "Deleted job result: ";
    var_dump($deleted);
} catch (Exception $e) {
    echo "[INFO] Delete not allowed or failed: " . $e->getMessage() . "\n";
} 