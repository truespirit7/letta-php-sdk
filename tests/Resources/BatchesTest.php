<?php

use PHPUnit\Framework\TestCase;
use Letta\Resources\Batches;
use Letta\Http\HttpClient;

class BatchesTest extends TestCase
{
    public function testCanInstantiate()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $batches = new Batches($mockHttp);
        $this->assertInstanceOf(Batches::class, $batches);
    }

    // TODO: Add tests for each endpoint method
    // TODO: Add integration tests
} 