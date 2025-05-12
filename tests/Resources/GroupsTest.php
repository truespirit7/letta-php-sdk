<?php

use PHPUnit\Framework\TestCase;
use Letta\Resources\Groups;
use Letta\Http\HttpClient;

class GroupsTest extends TestCase
{
    public function testCanInstantiate()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $groups = new Groups($mockHttp);
        $this->assertInstanceOf(Groups::class, $groups);
    }

    // TODO: Add tests for each endpoint method
    // TODO: Add integration tests
} 