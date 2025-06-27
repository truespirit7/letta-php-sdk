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
$count = $client->agents()->count();
echo "Agent count: $count\n"; 