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
$context = $client->agents()->getContext($agentId);
echo "Agent context:\n" . json_encode($context, JSON_PRETTY_PRINT) . "\n"; 