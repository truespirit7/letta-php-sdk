<?php

use PHPUnit\Framework\TestCase;
use Letta\Models\Tool;

class ToolTest extends TestCase
{
    public function testPropertyAssignment()
    {
        $tool = new Tool();
        $tool->id = 'tool-123';
        $tool->name = 'Test Tool';
        $tool->tool_type = 'custom';
        $this->assertEquals('tool-123', $tool->id);
        $this->assertEquals('Test Tool', $tool->name);
        $this->assertEquals('custom', $tool->tool_type);
    }

    // TODO: Add tests for validation and type safety
} 