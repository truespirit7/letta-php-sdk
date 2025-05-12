<?php

use PHPUnit\Framework\TestCase;
use Letta\Resources\Health;
use Letta\Http\HttpClient;

class HealthTest extends TestCase
{
    public function testCanInstantiate()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $health = new Health($mockHttp);
        $this->assertInstanceOf(Health::class, $health);
    }

    // TODO: Add tests for each endpoint method
    // TODO: Add integration tests
} 