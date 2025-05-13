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
    'description' => 'Example source created by script',
    'embedding' => 'openai/text-embedding-ada-002',
];
echo "Creating source with payload:\n" . json_encode($payload, JSON_PRETTY_PRINT) . "\n";
$source = $client->sources()->create($payload);
echo "Created source:\n" . json_encode($source, JSON_PRETTY_PRINT) . "\n";

$retrieved = $client->sources()->retrieve($source->id);
echo "Retrieved source:\n" . json_encode($retrieved, JSON_PRETTY_PRINT) . "\n"; 