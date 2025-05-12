<?php

use PHPUnit\Framework\TestCase;
use Letta\Models\Group;

class GroupTest extends TestCase
{
    public function testPropertyAssignment()
    {
        $group = new Group();
        $group->id = 'group-123';
        $group->manager_type = 'round_robin';
        $group->agent_ids = ['agent-1', 'agent-2'];
        $this->assertEquals('group-123', $group->id);
        $this->assertEquals('round_robin', $group->manager_type);
        $this->assertEquals(['agent-1', 'agent-2'], $group->agent_ids);
    }

    // TODO: Add tests for validation and type safety
} 