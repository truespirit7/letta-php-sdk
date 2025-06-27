<?php

use PHPUnit\Framework\TestCase;
use Letta\Models\Health;

class HealthModelTest extends TestCase
{
    public function testPropertyAssignment()
    {
        $health = new Health();
        $health->status = 'ok';
        $health->version = '1.0.0';
        $this->assertEquals('ok', $health->status);
        $this->assertEquals('1.0.0', $health->version);
    }

    // TODO: Add tests for validation and type safety
} 