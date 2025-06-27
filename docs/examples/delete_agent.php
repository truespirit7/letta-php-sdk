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
    'name' => 'delete_agent_' . uniqid(),
    'description' => 'Agent to be deleted',
];
$agent = $client->agents()->create($payload);
$agentId = $agent['id'] ?? $agent->id ?? null;
if ($agentId) {
    $deleted = $client->agents()->delete($agentId);
    echo "Deleted agent $agentId: " . ($deleted ? 'success' : 'failure') . "\n";
} else {
    echo "Failed to create agent for deletion example.\n";
} 