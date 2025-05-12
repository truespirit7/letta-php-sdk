<?php

use PHPUnit\Framework\TestCase;
use Letta\Resources\Agents;
use Letta\Http\HttpClient;

class AgentsTest extends TestCase
{
    public function testCanInstantiate()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $agents = new Agents($mockHttp);
        $this->assertInstanceOf(Agents::class, $agents);
    }

    // TODO: Add tests for each endpoint method
    // TODO: Add integration tests
} 