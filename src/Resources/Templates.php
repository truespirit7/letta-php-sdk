<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/templates endpoints.
 */
class Templates
{
    /**
     * @var HttpClient
     */
    private $http;

    /**
     * Templates constructor.
     *
     * @param HttpClient $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all templates.
     * GET /v1/templates/
     */
    public function list(array $params = [])
    {
        $response = $this->http->request('GET', '/v1/templates/');
        return $response;
    }
} 