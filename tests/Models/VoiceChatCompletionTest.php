<?php

use PHPUnit\Framework\TestCase;
use Letta\Models\VoiceChatCompletion;

class VoiceChatCompletionTest extends TestCase
{
    public function testPropertyAssignment()
    {
        $voice = new VoiceChatCompletion();
        $voice->transcript = 'Hello world';
        $voice->response_text = 'Hi!';
        $voice->message_id = 'msg-123';
        $this->assertEquals('Hello world', $voice->transcript);
        $this->assertEquals('Hi!', $voice->response_text);
        $this->assertEquals('msg-123', $voice->message_id);
    }

    // TODO: Add tests for validation and type safety
} 