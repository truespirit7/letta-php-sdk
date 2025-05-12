<?php

use PHPUnit\Framework\TestCase;
use Letta\Models\Block;

class BlockTest extends TestCase
{
    public function testPropertyAssignment()
    {
        $block = new Block();
        $block->id = 'block-123';
        $block->value = 'Test Value';
        $block->limit = 5000;
        $this->assertEquals('block-123', $block->id);
        $this->assertEquals('Test Value', $block->value);
        $this->assertEquals(5000, $block->limit);
    }

    // TODO: Add tests for validation and type safety
} 