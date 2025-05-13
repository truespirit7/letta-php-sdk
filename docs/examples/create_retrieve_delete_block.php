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
    'label' => 'example_block_' . uniqid(),
    'value' => 'Example block content',
];
echo "Creating block with payload:\n" . json_encode($payload, JSON_PRETTY_PRINT) . "\n";
$block = $client->blocks()->create($payload);
echo "Created block:\n" . json_encode($block, JSON_PRETTY_PRINT) . "\n";

$retrieved = $client->blocks()->retrieve($block->id);
echo "Retrieved block:\n" . json_encode($retrieved, JSON_PRETTY_PRINT) . "\n";

$deleted = $client->blocks()->delete($block->id);
echo "Deleted block result: ";
var_dump($deleted); 