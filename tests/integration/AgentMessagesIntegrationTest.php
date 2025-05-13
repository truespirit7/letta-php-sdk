<?php
namespace Tests\Integration;

use Tests\Integration\IntegrationTestCase;

class AgentMessagesIntegrationTest extends IntegrationTestCase
{
    private $agentId;
    private $lastMessageId;
    private $lastRunId;

    protected function setUp(): void
    {
        parent::setUp();
        $this->skipIfMissingEnv();
        $this->agentId = self::$testAgentId;
    }

    public function testSendMessageAndListMessages()
    {
        $client = $this->getClient();
        $message = [
            [
                'role' => 'user',
                'content' => [
                    ['type' => 'text', 'text' => 'Integration test message.']
                ]
            ]
        ];
        $client->agents()->sendMessage($this->agentId, $message);
        // Immediately list messages and check the sent user message is present
        $messages = $client->agents()->listMessages($this->agentId);
        echo "[DEBUG] listMessages response:\n" . json_encode($messages, JSON_PRETTY_PRINT) . "\n";
        $this->assertIsArray($messages);
        $found = false;
        foreach ($messages as $msg) {
            $role = $msg['role'] ?? $msg['message_type'] ?? null;
            $content = $msg['content'] ?? null;
            $text = null;
            if (is_array($content) && isset($content[0]['text'])) {
                $text = $content[0]['text'];
            } elseif (is_string($content)) {
                $text = $content;
            }
            if (($role === 'user' || $role === 'user_message') && $text === 'Integration test message.') {
                $found = true;
                $this->lastMessageId = $msg['id'] ?? null;
                break;
            }
        }
        if (!$found) {
            echo "[DEBUG] No matching user message found.\n";
        }
        $this->assertTrue($found, 'Sent user message should be in conversation history');
    }

    public function testModifyMessage()
    {
        $client = $this->getClient();
        // Send a message first
        $message = [
            [
                'role' => 'user',
                'content' => [
                    ['type' => 'text', 'text' => 'Message to modify.']
                ]
            ]
        ];
        $client->agents()->sendMessage($this->agentId, $message);
        // List messages and find the user message with the exact content
        $messages = $client->agents()->listMessages($this->agentId);
        echo "[DEBUG] listMessages response (for modify):\n" . json_encode($messages, JSON_PRETTY_PRINT) . "\n";
        $msgObj = null;
        foreach ($messages as $msg) {
            $role = $msg['role'] ?? $msg['message_type'] ?? null;
            $content = $msg['content'] ?? null;
            $text = null;
            if (is_array($content) && isset($content[0]['text'])) {
                $text = $content[0]['text'];
            } elseif (is_string($content)) {
                $text = $content;
            }
            if (($role === 'user' || $role === 'user_message') && $text === 'Message to modify.') {
                $msgObj = $msg;
                break;
            }
        }
        if (!$msgObj) {
            echo "[DEBUG] No matching user message found for modify.\n";
        }
        $this->assertNotNull($msgObj, 'User message should be present in conversation history');
        $messageId = $msgObj['id'] ?? null;
        $this->assertNotNull($messageId);
        echo "[DEBUG] Message to modify:\n" . json_encode($msgObj, JSON_PRETTY_PRINT) . "\n";

        // Modify the user message
        $newContent = 'Message has been modified.';
        $payload = [
            'content' => $newContent,
            'message_type' => 'user_message',
            'role' => 'user'
        ];
        echo "[DEBUG] modifyMessage payload:\n" . json_encode($payload, JSON_PRETTY_PRINT) . "\n";
        $modResp = $client->agents()->modifyMessage($this->agentId, $messageId, $payload);
        echo "[DEBUG] modifyMessage response:\n" . json_encode($modResp, JSON_PRETTY_PRINT) . "\n";
        $this->assertIsArray($modResp);
        $this->assertEquals($newContent, $modResp['content'] ?? $modResp['content'][0]['text'] ?? null);
    }

    public function testSendMessageAsync()
    {
        $client = $this->getClient();
        $message = [
            [
                'role' => 'user',
                'content' => [
                    ['type' => 'text', 'text' => 'Async test message.']
                ]
            ]
        ];
        $run = $client->agents()->sendMessageAsync($this->agentId, $message);
        $this->assertIsArray($run);
        $runId = $run['id'] ?? $run['run_id'] ?? null;
        $this->assertNotNull($runId);
        $this->lastRunId = $runId;

        // Poll for completion (max 30s)
        $maxWait = 30;
        $waited = 0;
        $status = null;
        while ($waited < $maxWait) {
            sleep(2);
            $waited += 2;
            $runStatus = $client->runs()->retrieve($runId);
            $status = $runStatus['status'] ?? $runStatus->status ?? null;
            if ($status === 'completed' || $status === 'failed') {
                break;
            }
        }
        $this->assertEquals('completed', $status, 'Async run should complete');
    }

    public function testResetMessages()
    {
        $client = $this->getClient();
        // Send a message to ensure there is history
        $message = [
            [
                'role' => 'user',
                'content' => [
                    ['type' => 'text', 'text' => 'Message before reset.']
                ]
            ]
        ];
        $client->agents()->sendMessage($this->agentId, $message);
        // Reset messages
        $resetResp = $client->agents()->resetMessages($this->agentId);
        $this->assertIsArray($resetResp);
        // List messages and check history is empty or only contains system messages
        $messages = $client->agents()->listMessages($this->agentId);
        $userMessages = array_filter($messages, function($msg) {
            return ($msg['role'] ?? $msg['message_type'] ?? null) === 'user' || ($msg['role'] ?? $msg['message_type'] ?? null) === 'user_message';
        });
        $this->assertEmpty($userMessages, 'User messages should be cleared after reset');
    }
} 