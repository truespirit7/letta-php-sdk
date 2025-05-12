<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/tags endpoint.
 */
class Tags
{
    /**
     * @var HttpClient
     */
    private $http;

    /**
     * Tags constructor.
     *
     * @param HttpClient $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all tags.
     * GET /v1/tags/
     */
    public function list()
    {
        // TODO: Implement
    }
} 