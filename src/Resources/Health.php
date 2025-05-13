<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/health endpoint.
 */
class Health
{
    /**
     * @var HttpClient
     */
    private $http;

    /**
     * Health constructor.
     *
     * @param HttpClient $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Check API health.
     * GET /v1/health
     */
    public function check()
    {
        $response = $this->http->request('GET', '/v1/health');
        return $response;
    }
} 