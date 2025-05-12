<?php

use PHPUnit\Framework\TestCase;
use Letta\Resources\Sources;
use Letta\Http\HttpClient;

class SourcesTest extends TestCase
{
    public function testCanInstantiate()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $sources = new Sources($mockHttp);
        $this->assertInstanceOf(Sources::class, $sources);
    }

    // TODO: Add tests for each endpoint method
    // TODO: Add integration tests
} 