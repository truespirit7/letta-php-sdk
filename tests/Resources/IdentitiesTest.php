<?php

use PHPUnit\Framework\TestCase;
use Letta\Resources\Identities;
use Letta\Http\HttpClient;

class IdentitiesTest extends TestCase
{
    public function testCanInstantiate()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $identities = new Identities($mockHttp);
        $this->assertInstanceOf(Identities::class, $identities);
    }

    // TODO: Add tests for each endpoint method
    // TODO: Add integration tests
} 