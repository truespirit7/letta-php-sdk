<?php

use PHPUnit\Framework\TestCase;
use Letta\Resources\Blocks;
use Letta\Http\HttpClient;

class BlocksTest extends TestCase
{
    public function testCanInstantiate()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $blocks = new Blocks($mockHttp);
        $this->assertInstanceOf(Blocks::class, $blocks);
    }

    // TODO: Add tests for each endpoint method
    // TODO: Add integration tests
} 