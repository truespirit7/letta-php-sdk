<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/providers endpoints.
 *
 * Provides methods to interact with Letta provider resources, including listing, creating, deleting, modifying, and checking providers.
 */
class Providers
{
    /**
     * @var HttpClient HTTP client for making API requests.
     */
    private $http;

    /**
     * Providers constructor.
     *
     * @param HttpClient $http HTTP client instance
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all providers.
     * GET /v1/providers/
     *
     * @param array $params Optional query parameters
     * @return array List of provider objects
     */
    public function list(array $params = [])
    {
        $response = $this->http->request('GET', '/v1/providers/');
        return $response;
    }

    /**
     * Create a new provider.
     * POST /v1/providers/
     *
     * @param array $data Provider creation payload
     * @return void
     * @todo Implement
     */
    public function create(array $data)
    {
        // TODO: Implement
    }

    /**
     * Delete provider by ID.
     * DELETE /v1/providers/{provider_id}
     *
     * @param string $providerId Provider ID
     * @return void
     * @todo Implement
     */
    public function delete(string $providerId)
    {
        // TODO: Implement
    }

    /**
     * Modify provider by ID.
     * PATCH /v1/providers/{provider_id}
     *
     * @param string $providerId Provider ID
     * @param array $data Modification payload
     * @return void
     * @todo Implement
     */
    public function modify(string $providerId, array $data)
    {
        // TODO: Implement
    }

    /**
     * Check provider by ID.
     * GET /v1/providers/check/{provider_id}
     *
     * @param string $providerId Provider ID
     * @return void
     * @todo Implement
     */
    public function check(string $providerId)
    {
        // TODO: Implement
    }
} 