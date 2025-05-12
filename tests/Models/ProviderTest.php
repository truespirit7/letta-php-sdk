<?php

use PHPUnit\Framework\TestCase;
use Letta\Models\Provider;

class ProviderTest extends TestCase
{
    public function testPropertyAssignment()
    {
        $provider = new Provider();
        $provider->id = 'provider-123';
        $provider->category = 'base';
        $provider->auth_status = 'valid';
        $this->assertEquals('provider-123', $provider->id);
        $this->assertEquals('base', $provider->category);
        $this->assertEquals('valid', $provider->auth_status);
    }

    // TODO: Add tests for validation and type safety
} 