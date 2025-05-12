<?php

use PHPUnit\Framework\TestCase;
use Letta\Resources\Tags;
use Letta\Http\HttpClient;

class TagsTest extends TestCase
{
    public function testCanInstantiate()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $tags = new Tags($mockHttp);
        $this->assertInstanceOf(Tags::class, $tags);
    }

    // TODO: Add tests for each endpoint method
    // TODO: Add integration tests
} 