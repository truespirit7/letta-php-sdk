<?php

use PHPUnit\Framework\TestCase;
use Letta\Resources\Steps;
use Letta\Http\HttpClient;

class StepsTest extends TestCase
{
    public function testCanInstantiate()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $steps = new Steps($mockHttp);
        $this->assertInstanceOf(Steps::class, $steps);
    }

    // TODO: Add tests for each endpoint method
    // TODO: Add integration tests
} 