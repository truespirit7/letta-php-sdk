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
    'name' => 'example_agent_' . uniqid(),
    'description' => 'Created from example script',
];
$agent = $client->agents()->create($payload);
echo "Created agent:\n" . json_encode($agent, JSON_PRETTY_PRINT) . "\n";
$agentId = $agent['id'] ?? $agent->id ?? null;
if ($agentId) {
    $client->agents()->delete($agentId);
    echo "Deleted agent: $agentId\n";
} 