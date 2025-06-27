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
$blockLabel = 'test_block';
$blockId = 'test_block_id';
try {
    $block = $client->agents()->getCoreMemoryBlock($agentId, $blockLabel);
    echo "Core memory block ($blockLabel):\n" . json_encode($block, JSON_PRETTY_PRINT) . "\n";
} catch (Exception $e) {
    echo "getCoreMemoryBlock not available: " . $e->getMessage() . "\n";
}
try {
    $modResp = $client->agents()->modifyCoreMemoryBlock($agentId, $blockLabel, ['data' => 'test']);
    echo "Modified core memory block ($blockLabel):\n" . json_encode($modResp, JSON_PRETTY_PRINT) . "\n";
} catch (Exception $e) {
    echo "modifyCoreMemoryBlock not available: " . $e->getMessage() . "\n";
}
try {
    $attachResp = $client->agents()->attachCoreMemoryBlock($agentId, $blockId);
    echo "Attached core memory block ($blockId):\n" . json_encode($attachResp, JSON_PRETTY_PRINT) . "\n";
    $detachResp = $client->agents()->detachCoreMemoryBlock($agentId, $blockId);
    echo "Detached core memory block ($blockId):\n" . json_encode($detachResp, JSON_PRETTY_PRINT) . "\n";
} catch (Exception $e) {
    echo "attach/detachCoreMemoryBlock not available: " . $e->getMessage() . "\n";
} 