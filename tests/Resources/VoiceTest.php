<?php

use PHPUnit\Framework\TestCase;
use Letta\Resources\Voice;
use Letta\Http\HttpClient;

class VoiceTest extends TestCase
{
    public function testCanInstantiate()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $voice = new Voice($mockHttp);
        $this->assertInstanceOf(Voice::class, $voice);
    }

    // TODO: Add tests for each endpoint method
    // TODO: Add integration tests
} 