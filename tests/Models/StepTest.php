<?php

use PHPUnit\Framework\TestCase;
use Letta\Models\Step;

class StepTest extends TestCase
{
    public function testPropertyAssignment()
    {
        $step = new Step();
        $step->id = 'step-123';
        $step->type = 'thought';
        $step->input = 'input';
        $this->assertEquals('step-123', $step->id);
        $this->assertEquals('thought', $step->type);
        $this->assertEquals('input', $step->input);
    }

    // TODO: Add tests for validation and type safety
} 