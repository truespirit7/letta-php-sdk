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
$runs = $client->runs()->list();
echo "Runs list:\n" . json_encode($runs, JSON_PRETTY_PRINT) . "\n";

if (empty($runs)) {
    echo "[INFO] No runs available to retrieve or delete.\n";
    exit(0);
}

$run = $runs[0];
$runId = $run['id'] ?? $run->id ?? null;
if (!$runId) {
    echo "[ERROR] No run ID found in first run.\n";
    exit(1);
}

$retrieved = $client->runs()->retrieve($runId);
echo "Retrieved run:\n" . json_encode($retrieved, JSON_PRETTY_PRINT) . "\n";

try {
    $deleted = $client->runs()->delete($runId);
    echo "Deleted run result: ";
    var_dump($deleted);
} catch (Exception $e) {
    echo "[INFO] Delete not allowed or failed: " . $e->getMessage() . "\n";
} 