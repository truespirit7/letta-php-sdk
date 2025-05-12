<?php

namespace Letta\Http;

/**
 * Handles HTTP requests for the Letta SDK, including authentication.
 */
class HttpClient
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $token;

    /**
     * HttpClient constructor.
     *
     * @param string $baseUrl
     * @param string $token
     */
    public function __construct(string $baseUrl, string $token)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->token = $token;
    }

    /**
     * Send an HTTP request to the Letta API.
     *
     * @param string $method HTTP method (GET, POST, etc.)
     * @param string $path API endpoint path (e.g., '/v1/agents')
     * @param array $options Request options (query, body, headers, etc.)
     * @return array Response data (to be defined)
     *
     * @throws \Exception on HTTP or network error
     */
    public function request(string $method, string $path, array $options = []): array
    {
        // TODO: Implement HTTP request logic (e.g., using curl or Guzzle)
        // TODO: Add Bearer token to Authorization header
        // TODO: Handle errors and parse responses
        throw new \Exception('HttpClient::request() not implemented yet.');
    }

    // TODO: Add helper methods for GET, POST, etc. if needed
} 