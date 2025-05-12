<?php

use PHPUnit\Framework\TestCase;
use Letta\Models\Tag;

class TagTest extends TestCase
{
    public function testPropertyAssignment()
    {
        $tag = new Tag();
        $tag->name = 'test-tag';
        $this->assertEquals('test-tag', $tag->name);
    }

    // TODO: Add tests for validation and type safety
} 