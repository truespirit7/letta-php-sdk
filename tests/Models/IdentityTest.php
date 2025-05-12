<?php

use PHPUnit\Framework\TestCase;
use Letta\Models\Identity;

class IdentityTest extends TestCase
{
    public function testPropertyAssignment()
    {
        $identity = new Identity();
        $identity->id = 'identity-123';
        $identity->name = 'Test Identity';
        $identity->description = 'A test identity.';
        $this->assertEquals('identity-123', $identity->id);
        $this->assertEquals('Test Identity', $identity->name);
        $this->assertEquals('A test identity.', $identity->description);
    }

    // TODO: Add tests for validation and type safety
} 