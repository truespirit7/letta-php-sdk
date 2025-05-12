<?php

use PHPUnit\Framework\TestCase;
use Letta\Resources\Providers;
use Letta\Http\HttpClient;

class ProvidersTest extends TestCase
{
    public function testCanInstantiate()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $providers = new Providers($mockHttp);
        $this->assertInstanceOf(Providers::class, $providers);
    }

    // TODO: Add tests for each endpoint method
    // TODO: Add integration tests
} 