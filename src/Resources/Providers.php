<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/providers endpoints.
 */
class Providers
{
    /**
     * @var HttpClient
     */
    private $http;

    /**
     * Providers constructor.
     *
     * @param HttpClient $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all providers.
     * GET /v1/providers/
     */
    public function list(array $params = [])
    {
        $response = $this->http->request('GET', '/v1/providers/');
        return $response;
    }

    /**
     * Create a new provider.
     * POST /v1/providers/
     */
    public function create(array $data)
    {
        // TODO: Implement
    }

    /**
     * Delete provider by ID.
     * DELETE /v1/providers/{provider_id}
     */
    public function delete(string $providerId)
    {
        // TODO: Implement
    }

    /**
     * Modify provider by ID.
     * PATCH /v1/providers/{provider_id}
     */
    public function modify(string $providerId, array $data)
    {
        // TODO: Implement
    }

    /**
     * Check provider by ID.
     * GET /v1/providers/check/{provider_id}
     */
    public function check(string $providerId)
    {
        // TODO: Implement
    }
} 