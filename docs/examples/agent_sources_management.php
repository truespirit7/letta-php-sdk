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
$agentId = $_ENV['LETTA_TEST_AGENT_ID'] ?? null;

if (!$apiUrl || !$apiToken || !$agentId) {
    fwrite(STDERR, "Missing LETTA_API_URL, LETTA_API_TOKEN, or LETTA_TEST_AGENT_ID in environment.\n");
    exit(1);
}

$client = new Client($apiToken, $apiUrl);
$sources = $client->agents()->listSources($agentId);
echo "Agent sources:\n" . json_encode($sources, JSON_PRETTY_PRINT) . "\n";
if (!empty($sources) && isset($sources[0]['id'])) {
    $sourceId = $sources[0]['id'];
    $attachResp = $client->agents()->attachSource($agentId, $sourceId);
    echo "Attached source $sourceId:\n" . json_encode($attachResp, JSON_PRETTY_PRINT) . "\n";
    $detachResp = $client->agents()->detachSource($agentId, $sourceId);
    echo "Detached source $sourceId:\n" . json_encode($detachResp, JSON_PRETTY_PRINT) . "\n";
} else {
    echo "No sources available to attach/detach.\n";
} 