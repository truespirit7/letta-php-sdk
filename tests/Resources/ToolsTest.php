<?php

use PHPUnit\Framework\TestCase;
use Letta\Resources\Tools;
use Letta\Http\HttpClient;

class ToolsTest extends TestCase
{
    public function testCanInstantiate()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $tools = new Tools($mockHttp);
        $this->assertInstanceOf(Tools::class, $tools);
    }

    // TODO: Add tests for each endpoint method
    // TODO: Add integration tests
} 