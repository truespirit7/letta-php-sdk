<?php
require 'vendor/autoload.php';
use Letta\Client;
use Dotenv\Dotenv;

Dotenv::createImmutable(__DIR__.'/tests/integration')->load();
$apiUrl = trim($_ENV['LETTA_API_URL'] ?? '');
$apiToken = trim($_ENV['LETTA_API_TOKEN'] ?? '');
echo "API URL: $apiUrl\n";
echo "API Token: " . substr($apiToken, 0, 4) . "...\n";
$client = new Client($apiToken, $apiUrl);
try {
    $tools = $client->tools()->list();
    echo "Tools list:\n";
    print_r($tools);
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
} 