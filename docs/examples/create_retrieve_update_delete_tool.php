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
    'source_code' => "def add(a: int, b: int) -> int:\n    \"\"\"\n    Add two numbers.\n    Args:\n        a (int): First number.\n        b (int): Second number.\n    Returns:\n        int: The sum.\n    \"\"\"\n    return a + b\n\njson_schema = {\n    'type': 'object',\n    'properties': {\n        'a': {'type': 'integer', 'description': 'First number.'},\n        'b': {'type': 'integer', 'description': 'Second number.'}\n    },\n    'required': ['a', 'b']\n}\n"
];
echo "Creating tool with payload:\n" . json_encode($payload, JSON_PRETTY_PRINT) . "\n";
$tool = $client->tools()->create($payload);
echo "Created tool:\n" . json_encode($tool, JSON_PRETTY_PRINT) . "\n";

$retrieved = $client->tools()->retrieve($tool->id);
echo "Retrieved tool:\n" . json_encode($retrieved, JSON_PRETTY_PRINT) . "\n";

$updated = $client->tools()->update($tool->id, [
    'description' => 'Updated description from example script'
]);
echo "Updated tool:\n" . json_encode($updated, JSON_PRETTY_PRINT) . "\n";

$deleted = $client->tools()->delete($tool->id);
echo "Deleted tool result: ";
var_dump($deleted); 