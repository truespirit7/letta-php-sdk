<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/steps endpoints.
 */
class Steps
{
    /**
     * @var HttpClient
     */
    private $http;

    /**
     * Steps constructor.
     *
     * @param HttpClient $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all steps.
     * GET /v1/steps/
     */
    public function list(array $params = [])
    {
        $response = $this->http->request('GET', '/v1/steps/', [
            'query' => $params
        ]);
        return $response;
    }

    /**
     * Retrieve step by ID.
     * GET /v1/steps/{step_id}
     */
    public function retrieve(string $stepId)
    {
        $response = $this->http->request('GET', "/v1/steps/{$stepId}");
        return $response;
    }
} 