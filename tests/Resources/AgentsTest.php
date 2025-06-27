<?php

use PHPUnit\Framework\TestCase;
use Letta\Resources\Agents;
use Letta\Http\HttpClient;

class AgentsTest extends TestCase
{
    public function testCanInstantiate()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $agents = new Agents($mockHttp);
        $this->assertInstanceOf(Agents::class, $agents);
    }

    public function testList()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $mockHttp->method('request')->willReturn([]);
        $agents = new Agents($mockHttp);
        $this->assertIsArray($agents->list());
    }

    public function testCreate()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $mockHttp->method('request')->willReturn(['id' => 'test']);
        $agents = new Agents($mockHttp);
        $result = $agents->create(['name' => 'test']);
        $this->assertArrayHasKey('id', $result);
    }

    public function testCount()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $mockHttp->method('request')->willReturn(['count' => 1]);
        $agents = new Agents($mockHttp);
        $this->assertEquals(1, $agents->count());
    }

    public function testExport()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $mockHttp->method('request')->willReturn(['data' => 'exported']);
        $agents = new Agents($mockHttp);
        $this->assertArrayHasKey('data', $agents->export('id'));
    }

    public function testImport()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $mockHttp->method('request')->willReturn(['id' => 'imported']);
        $agents = new Agents($mockHttp);
        $this->assertArrayHasKey('id', $agents->import(['data' => 'x']));
    }

    public function testDelete()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $mockHttp->method('request')->willReturn([]);
        $agents = new Agents($mockHttp);
        $this->assertTrue($agents->delete('id'));
    }

    public function testModify()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $mockHttp->method('request')->willReturn(['description' => 'mod']);
        $agents = new Agents($mockHttp);
        $this->assertEquals('mod', $agents->modify('id', ['description' => 'mod'])['description']);
    }

    public function testGetContext()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $mockHttp->method('request')->willReturn(['context' => 'x']);
        $agents = new Agents($mockHttp);
        $this->assertArrayHasKey('context', $agents->getContext('id'));
    }

    public function testListTools()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $mockHttp->method('request')->willReturn([]);
        $agents = new Agents($mockHttp);
        $this->assertIsArray($agents->listTools('id'));
    }

    public function testAttachTool()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $mockHttp->method('request')->willReturn(['attached' => true]);
        $agents = new Agents($mockHttp);
        $this->assertArrayHasKey('attached', $agents->attachTool('id', 'tid'));
    }

    public function testDetachTool()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $mockHttp->method('request')->willReturn(['detached' => true]);
        $agents = new Agents($mockHttp);
        $this->assertArrayHasKey('detached', $agents->detachTool('id', 'tid'));
    }

    public function testListSources()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $mockHttp->method('request')->willReturn([]);
        $agents = new Agents($mockHttp);
        $this->assertIsArray($agents->listSources('id'));
    }

    public function testAttachSource()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $mockHttp->method('request')->willReturn(['attached' => true]);
        $agents = new Agents($mockHttp);
        $this->assertArrayHasKey('attached', $agents->attachSource('id', 'sid'));
    }

    public function testDetachSource()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $mockHttp->method('request')->willReturn(['detached' => true]);
        $agents = new Agents($mockHttp);
        $this->assertArrayHasKey('detached', $agents->detachSource('id', 'sid'));
    }

    public function testGetCoreMemoryBlock()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $mockHttp->method('request')->willReturn(['block' => 'x']);
        $agents = new Agents($mockHttp);
        $this->assertArrayHasKey('block', $agents->getCoreMemoryBlock('id', 'label'));
    }

    public function testModifyCoreMemoryBlock()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $mockHttp->method('request')->willReturn(['block' => 'mod']);
        $agents = new Agents($mockHttp);
        $this->assertArrayHasKey('block', $agents->modifyCoreMemoryBlock('id', 'label', ['data' => 'x']));
    }

    public function testAttachCoreMemoryBlock()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $mockHttp->method('request')->willReturn(['attached' => true]);
        $agents = new Agents($mockHttp);
        $this->assertArrayHasKey('attached', $agents->attachCoreMemoryBlock('id', 'bid'));
    }

    public function testDetachCoreMemoryBlock()
    {
        $mockHttp = $this->createMock(HttpClient::class);
        $mockHttp->method('request')->willReturn(['detached' => true]);
        $agents = new Agents($mockHttp);
        $this->assertArrayHasKey('detached', $agents->detachCoreMemoryBlock('id', 'bid'));
    }

    // TODO: Add integration tests
} 