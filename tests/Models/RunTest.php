<?php

use PHPUnit\Framework\TestCase;
use Letta\Models\Run;

class RunTest extends TestCase
{
    public function testPropertyAssignment()
    {
        $run = new Run();
        $run->id = 'run-123';
        $run->status = 'completed';
        $run->job_type = 'job';
        $this->assertEquals('run-123', $run->id);
        $this->assertEquals('completed', $run->status);
        $this->assertEquals('job', $run->job_type);
    }

    // TODO: Add tests for validation and type safety
} 