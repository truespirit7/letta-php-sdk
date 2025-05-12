<?php

use PHPUnit\Framework\TestCase;
use Letta\Models\Source;

class SourceTest extends TestCase
{
    public function testPropertyAssignment()
    {
        $source = new Source();
        $source->id = 'source-123';
        $source->name = 'Test Source';
        $source->description = 'A test source.';
        $this->assertEquals('source-123', $source->id);
        $this->assertEquals('Test Source', $source->name);
        $this->assertEquals('A test source.', $source->description);
    }

    // TODO: Add tests for validation and type safety
} 