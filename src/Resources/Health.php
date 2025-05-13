<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/health endpoint.
 *
 * Provides a method to check the health status of the Letta API.
 */
class Health
{
    /**
     * @var HttpClient HTTP client for making API requests.
     */
    private $http;

    /**
     * Health constructor.
     *
     * @param HttpClient $http HTTP client instance
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Check API health.
     * GET /v1/health
     *
     * @return array Health status response
     */
    public function check()
    {
        $response = $this->http->request('GET', '/v1/health');
        return $response;
    }
} 