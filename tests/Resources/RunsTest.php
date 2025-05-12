<?php

use PHPUnit\Framework\TestCase;
use Letta\Resources\Runs;
use Letta\Http\HttpClient;

class RunsTest extends TestCase
{
    public function testCanInstantiate()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $runs = new Runs($mockHttp);
        $this->assertInstanceOf(Runs::class, $runs);
    }

    // TODO: Add tests for each endpoint method
} 