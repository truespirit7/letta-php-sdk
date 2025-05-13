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

// Send a message to the agent
$message = [
    [
        'role' => 'user',
        'content' => [
            ['type' => 'text', 'text' => 'Hello, agent! This is a test message.']
        ]
    ]
];
echo "Sending message to agent...\n";
$response = $client->agents()->sendMessage($agentId, $message);
echo "Response from agent:\n" . json_encode($response, JSON_PRETTY_PRINT) . "\n";

// List conversation history
$messages = $client->agents()->listMessages($agentId);
echo "\nConversation history:\n" . json_encode($messages, JSON_PRETTY_PRINT) . "\n"; 