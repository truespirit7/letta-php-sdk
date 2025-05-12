<?php

use PHPUnit\Framework\TestCase;
use Letta\Resources\Templates;
use Letta\Http\HttpClient;

class TemplatesTest extends TestCase
{
    public function testCanInstantiate()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $templates = new Templates($mockHttp);
        $this->assertInstanceOf(Templates::class, $templates);
    }

    // TODO: Add tests for each endpoint method
    // TODO: Add integration tests
} 