<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/tags endpoint.
 *
 * Provides a method to list all tags in the Letta system.
 */
class Tags
{
    /**
     * @var HttpClient HTTP client for making API requests.
     */
    private $http;

    /**
     * Tags constructor.
     *
     * @param HttpClient $http HTTP client instance
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all tags.
     * GET /v1/tags/
     *
     * @return array List of tags
     */
    public function list()
    {
        $response = $this->http->request('GET', '/v1/tags/');
        return $response;
    }
} 