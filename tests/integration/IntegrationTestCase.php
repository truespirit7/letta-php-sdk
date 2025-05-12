<?php
namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

abstract class IntegrationTestCase extends TestCase
{
    protected static $apiUrl;
    protected static $apiToken;
    protected static $testAgentId;
    
    public static function setUpBeforeClass(): void
    {
        $envPath = __DIR__;
        if (file_exists($envPath . '/.env')) {
            $dotenv = Dotenv::createImmutable($envPath);
            $dotenv->load();
        }
        self::$apiUrl = $_ENV['LETTA_API_URL'] ?? null;
        self::$apiToken = $_ENV['LETTA_API_TOKEN'] ?? null;
        self::$testAgentId = $_ENV['LETTA_TEST_AGENT_ID'] ?? null;
    }

    protected function skipIfMissingEnv()
    {
        if (!self::$apiUrl || !self::$apiToken || !self::$testAgentId) {
            $this->markTestSkipped('Integration test environment variables are not set.');
        }
    }
} 