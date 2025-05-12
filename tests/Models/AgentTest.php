<?php

use PHPUnit\Framework\TestCase;
use Letta\Models\Agent;

class AgentTest extends TestCase
{
    public function testPropertyAssignment()
    {
        $agent = new Agent();
        $agent->id = 'agent-123';
        $agent->name = 'Test Agent';
        $agent->tags = ['test'];
        $this->assertEquals('agent-123', $agent->id);
        $this->assertEquals('Test Agent', $agent->name);
        $this->assertEquals(['test'], $agent->tags);
    }

    // TODO: Add tests for validation and type safety
} 